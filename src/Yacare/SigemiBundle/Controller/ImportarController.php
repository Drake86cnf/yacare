<?php

namespace Yacare\SigemiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Yacare\BaseBundle\Helper\StringHelper;
use Symfony\Component\HttpFoundation\StreamedResponse;


/**
 * @Route("importar/")
 */
class ImportarController extends Controller
{
    /**
     * @Route("partidas/")
     * @Template("YacareSigemiBundle:Importar:importar.html.twig")
     */
    public function importarPartidasAction()
    {
        //DELETE FROM Catastro_Partida WHERE id NOT IN (SELECT DISTINCT Partida_id FROM Inspeccion_RelevamientoAsignacionDetalle);
        
        
        $request = $this->getRequest();
        $desde = (int)($request->query->get('desde'));
        $cant = 500;
        
        mb_internal_encoding('UTF-8');
        ini_set('display_errors', 1);
        set_time_limit(600);
        ini_set('memory_limit', '2048M');
        
        $Zonas = array(
            'ZC' => 2,
            'ZCB' => 7,
            'ZCM' => 4,
            'ZCP' => 5,
            'CRT1' => 3,
            'ZCRT1' => 3,
            'ZCS' => 6,
            'ZMC' => 1,
            'ZC-MC' => 1,
            'ZPE' => 15,
            'ZR1' => 8,
            'ZR2' => 9,
            'ZR3' => 10,
            'ZR4' => 11,
            'ZR5' => 12,
            'ZR6' => 13,
            'ZREU' => 16,
            'ZRM' => 14,
            'ZSEU' => 18,
            
            // Estos no existen en el SIGEMI
            'Z extra urb. zona costera' => 19,
            'Z residencial extraurbano 2' => 17,
            
            // Estos no existen en el anexo 6 de planificación territorial
            'ZEIA' => null,
            'ZEIS' => null,
            'ZEIU' => null,
        );

        $Dbmunirg = $this->ConectarOracle();
        
        $em = $this->getDoctrine()->getManager();
        $em->getConnection()->beginTransaction();
        
        $importar_importados = 0;
        $importar_actualizados = 0;
        $importar_procesados = 0;
        $log = array();
        $sql = "
SELECT * FROM (
    SELECT a.*, ROWNUM rnum FROM (

SELECT tr3a100.tr3a100_id,
          tr3a100.catastro_id,
          tr3a100.nomenclatura_cat,
          tr3a100.estado,
          tr3a100.categoria,
          tr3a100.zona_codigo,
          tr3a100\$rgr.chacra,
          tr3a100\$rgr.seccion,
          tr3a100\$rgr.macizo_num,
          tr3a100\$rgr.macizo_alfa,
          tr3a100\$rgr.parcela_num,
          tr3a100\$rgr.parcela_alfa,
          tr3a100\$rgr.subparc_num,
          tr3a100\$rgr.subparc_alfa,
          tr3a100\$rgr.unid_func,
          tr3a100\$rgr.legajo,
          TG06300.CODIGO_CALLE,
          TG06300.CALLE,
          TG06300.NUMERO,
          TG06300.PISO,
          TG06300.DEPARTAMENTO,
          TR3A100.ZONA_CURB,
          tr02100.TIT_TG06100_ID
     FROM tr3a100
          JOIN tr3a100\$rgr
             ON (tr3a100.tr3a100_id = tr3a100\$rgr.tr3a100_tr3a100_id)
          JOIN TG06300
             ON (TG06300.TG06300_ID = tr3a100.TG06300_TG06300_ID)
          LEFT JOIN tr02100
             ON (tr02100.tr02100_id = tr3a100\$rgr.tr02100_tr02100_id)
     WHERE tr3a100.estado='AL'
        AND tr3a100.lugar='RGR'
        AND tr02100.DEFINITIVO='D'
        AND tr02100.IMPONIBLE_TIPO='OSA'

     ORDER BY tr3a100.catastro_id
) a 
    WHERE ROWNUM <=" . ($desde + $cant) . ")
WHERE rnum >" . $desde . "
";
        foreach($Dbmunirg->query($sql) as $Row) {
            $Seccion = strtoupper(trim($Row['SECCION'], ' .'));
            $MacizoNum = trim($Row['MACIZO_NUM'], ' .');
            $MacizoAlfa = trim($Row['MACIZO_ALFA'], ' .');
            $ParcelaNum = trim($Row['PARCELA_NUM'], ' .');
            $ParcelaAlfa = trim($Row['PARCELA_ALFA'], ' .');
            $Macizo = trim($MacizoNum . $MacizoAlfa);
            $Parcela = trim($ParcelaNum . $ParcelaAlfa);
            $UnidadFuncional = (int)($Row['UNID_FUNC']);
            
            $entity = null;
            /* $entity = $em->getRepository('YacareCatastroBundle:Partida')->findOneBy(array(
                'ImportSrc' => 'dbmunirg.TR3A100',
                'ImportId' => $Row['TR3A100_ID']
            )); */

            if(!$entity) {
                $entity = $em->getRepository('YacareCatastroBundle:Partida')->findOneBy(array(
                    'Seccion' => $Seccion,
                    'Macizo' => $Macizo,
                    'Parcela' => $Parcela,
                    'UnidadFuncional' => $UnidadFuncional,
                ));
            }
            
            if(!$entity) {
                $entity = $em->getRepository('YacareCatastroBundle:Partida')->findOneBy(array(
                    'Numero' => (int)($Row['CATASTRO_ID'])
                ));
            }
            
            if(!$entity) {
                $entity = new \Yacare\CatastroBundle\Entity\Partida();
                $entity->setSeccion($Seccion);
                $entity->setMacizoAlfa($MacizoAlfa);
                $entity->setMacizoNum($MacizoNum);
                $entity->setMacizo($Macizo);
                $entity->setParcelaAlfa($ParcelaAlfa);
                $entity->setParcelaNum($ParcelaNum);
                $entity->setParcela($Parcela);
                
                $importar_importados++;
            } else {
                $importar_actualizados++;
            }
                
            if($entity && $Seccion) {
                if($Row['CODIGO_CALLE']) {
                    $entity->setDomicilioCalle($em->getReference('YacareCatastroBundle:Calle', $Row['CODIGO_CALLE']));
                }
                
                if($Row['ZONA_CURB']) {
                    $ZonaId = @$Zonas[$Row['ZONA_CURB']];
                    if($ZonaId) {
                        $entity->setZona($em->getReference('YacareCatastroBundle:Zona', $ZonaId));
                    } else {
                        $entity->setZona(null);
                    }
                } else {
                    $entity->setZona(null);
                }
                
                if($Row['TIT_TG06100_ID']) {
                    $titular = $em->getRepository('YacareBaseBundle:Persona')->findOneBy(array(
                        'Tg06100Id' => $Row['TIT_TG06100_ID']
                    ));
                    $entity->setTitular($titular);
                    if($titular)
                        $log[] = "titular encontrado " . $Row['TIT_TG06100_ID'] . ': ' . $titular;
                    else
                        $log[] = "titular NO encontrado " . $Row['TIT_TG06100_ID'];
                } else {
                    $log[] = "*** Sin titular " . $Row['TIT_TG06100_ID'];
                    $entity->setTitular(null);
                }

                $entity->setUnidadFuncional($UnidadFuncional);
                $entity->setDomicilioNumero((int)($Row['NUMERO']));
                $entity->setDomicilioPiso(trim($Row['PISO']));
                $entity->setDomicilioPuerta(trim($Row['DEPARTAMENTO']));
                $entity->setLegajo((int)($Row['LEGAJO']));
                $entity->setNumero((int)($Row['CATASTRO_ID']));

                //$entity->setImportSrc('dbmunirg.TR3A100');
                //$entity->setImportId($Row['TR3A100_ID']);

                $em->persist($entity);
                $em->flush();
                //$log[] = $Row['CATASTRO_ID'] . " SMP($Seccion-$Macizo-$Parcela-$UnidadFuncional) ${Row['CALLE']} #${Row['NUMERO']} --- " . $entity->getTitular();
            }
            
            $importar_procesados++;
        }
        
        $em->getConnection()->commit();
        
        return array(
            'importar_importados' => $importar_importados,
            'importar_actualizados' => $importar_actualizados,
            'importar_procesados' => $importar_procesados,
            'redir_desde' => ($importar_procesados == $cant ? $desde + $cant : 0),
            'log' => $log
            );
    }
    
    
    
    
    
    
    
    
    
    /**
     * @Route("personas/")
     * @Template("YacareSigemiBundle:Importar:importar.html.twig")
     */
    public function importarPersonasAction($desde = 0)
    {
        $request = $this->getRequest();
        $desde = (int)($request->query->get('desde'));
        $cant = 500;
        
        mb_internal_encoding('UTF-8');
        set_time_limit(600);
        ini_set('display_errors', 1);
        ini_set('memory_limit', '1024M');
        
        $TipoDocs = array(
            'DNI' => 1,
            'CF' => 1,
            'LE' => 2,
            'LC' => 3,
            'CI' => 4,
            'PAS' => 5,
            'CUIL' => 98,
            'CUIT' => 99,
        );
        
        $Dbmunirg = $this->ConectarOracle();

        $em = $this->getDoctrine()->getManager();
        $em->getConnection()->beginTransaction();
        
        $importar_importados = 0;
        $importar_actualizados = 0;
        $importar_procesados = 0;
        $log = array();
        
        $sql = "
SELECT * FROM (
    SELECT a.*, ROWNUM rnum FROM (

SELECT
    a.IND_LEYENDA,
    a.IND_IDENTIFICACION,
    a.NOMBRE,
    a.TG06100_ID,
    a.ALTA_FECHA,
    a.TELEFONOS,
    a.E_MAIL,
    a.BAJA_FECHA,
    a.BAJA_MOTIVO,
    a.INDIVIDUO_TIPO,
    a.TG06300_TG06300_ID,
    a.TR02100_TR02100_ID,
    p.APELLIDOS Q_APELLIDOS,
    p.NOMBRES Q_NOMBRES,
    p.SEXO Q_SEXO,
    p.NACIMIENTO_FECHA Q_NACIMIENTO_FECHA,
    p.NACIMIENTO_LUGAR Q_NACIMIENTO_LUGAR,
    p.NACIONALIDAD Q_NACIONALIDAD,
    j.RAZON_SOCIAL J_RAZON_SOCIAL,
    j.TIPO_SOCIEDAD J_TIPO_SOCIEDAD,
    j.NOMBRE_FANTASIA J_NOMBRE_FANTASIA,
    j.IDENTIFICACION_TRIBUTARIA J_IDENTIFICACION_TRIBUTARIA,
    d.PAIS,
    d.PROVINCIA,
    d.CODIGO_POSTAL,
    d.LOCALIDAD,
    d.CODIGO_CALLE,
    d.CALLE,
    d.NUMERO,
    d.NUMERO_EXTENSION,
    d.PISO,
    d.DEPARTAMENTO,
    d.LOCAL,
    d.DOMICILIO_EXTENSION,
    doc.DOCUMENTO_TIPO,
    doc.DOCUMENTO_NRO
FROM TG06100X a
    LEFT JOIN TG06110 p ON a.TG06100_ID = p.TG06100_TG06100_ID
    LEFT JOIN TG06120 j ON a.TG06100_ID = j.TG06100_TG06100_ID
    LEFT JOIN TG06300 d ON a.TG06300_TG06300_ID = d.TG06300_ID
    JOIN TG06111 doc ON a.TG06100_ID = doc.TG06110_TG06100_TG06100_ID
    JOIN TR02100 imp ON a.TG06100_ID = imp.TIT_TG06100_ID
WHERE a.BAJA_MOTIVO IS NULL
    AND a.NOMBRE<>'NN'
    AND imp.IMPONIBLE_TIPO='IND' AND imp.DEFINITIVO='D'
    AND d.LOCALIDAD='RIO GRANDE' 
    AND a.NOMBRE NOT LIKE '?%'
    AND LENGTH(doc.DOCUMENTO_NRO) >= 5
ORDER BY a.TG06100_ID

) a 
    WHERE ROWNUM <=" . ($desde + $cant) . ")
WHERE rnum >" . $desde . "
";
        
        foreach($Dbmunirg->query($sql) as $Row) {
            $Documento = StringHelper::ObtenerDocumento($Row['IND_IDENTIFICACION']);
            $Apellido = StringHelper::Desoraclizar($Row['Q_APELLIDOS']);
            $Nombre = StringHelper::Desoraclizar($Row['Q_NOMBRES']);
            $RazonSocial = StringHelper::Desoraclizar($Row['J_RAZON_SOCIAL']);
            $PersJur = false;

            if($Documento[0] == 'CUIL' && 
                    (substr($Documento[1], 0, 3) == '30-'
                    || substr($Documento[1], 0, 3) == '33-')
                    ) {
                $Documento[0] = 'CUIT';
                $PersJur = true;
            }
            
            if($Row['DOCUMENTO_TIPO'] == 'DU') {
                $Row['DOCUMENTO_TIPO'] = 'DNI';
            }
            
            $Cuilt = '';
            if($Documento[0] == 'CUIL' || $Documento[0] == 'CUIT') {
                $Cuilt = str_replace('-', '', $Documento[1]);
                $Documento[0] = $Row['DOCUMENTO_TIPO'];
                $Documento[1] = $Row['DOCUMENTO_NRO'];
            } else if($Row['DOCUMENTO_TIPO'] == 'CUIL' || $Row['DOCUMENTO_TIPO'] == 'CUIT') {
                $Cuilt = str_replace('-', '', $Row['DOCUMENTO_NRO']);
            }
            
            if($Documento[0] == 'CUIL') {
                $Partes = explode('-', $Documento[1]);
                if(count($Partes) == 3) {
                    $Documento[0] = 'DNI';
                    $Documento[1] = (int)($Partes[1]);
                }
            }
            
            if(!$Nombre && !$Apellido) {
                $Apellido = StringHelper::Desoraclizar($Row['NOMBRE']);
            }
            
            if(!$Nombre && $Apellido && strpos($Apellido, '.') === false) {
                $a = explode(' ', $Apellido, 2)[0];
                $b = trim(substr($Apellido, strlen($a)));
                $Nombre = $b;
                $Apellido = $a;
            }
            
            if($RazonSocial) {
                $NombreVisible = $RazonSocial;
            } else if($Nombre) {
                $NombreVisible = $Apellido . ', ' . $Nombre;
            } else {
                $NombreVisible = $Apellido;
            }
            
            $Row['TG06100_ID'] = (int)($Row['TG06100_ID']);
            
            // Arreglar errores conocidos
            if($Row['CODIGO_CALLE'] == 380) {
                $Row['CODIGO_CALLE'] = null;            // No existe
            } else if($Row['CODIGO_CALLE'] == 384) {    // Santa María Dominga Mazzarello
                $Row['CODIGO_CALLE'] = 389;             // Este es el código correcto
            } else if($Row['CODIGO_CALLE'] == 454) {    // Juana Manuela Gorriti
                $Row['CODIGO_CALLE'] = 249;
            } else if($Row['CODIGO_CALLE'] == 1482) {   // General Villegas
                $Row['CODIGO_CALLE'] = 211;
            } else if($Row['CODIGO_CALLE'] == 724) {    // Remolcador Guaraní
                $Row['CODIGO_CALLE'] = 69;
            } else if($Row['CODIGO_CALLE'] == 567) {    // Neuquén
                $Row['CODIGO_CALLE'] = 144;
            } else if((int)($Row['CODIGO_CALLE']) == 0 || $Row['CODIGO_CALLE'] == 1748) {  // ???
                $Row['CODIGO_CALLE'] = null;
            } else if($Row['CODIGO_CALLE'] == 1157) {   // 25 de Mayo
                $Row['CODIGO_CALLE'] = 224;
            } else if($Row['CODIGO_CALLE'] == 474) {    // Rosales
                $Row['CODIGO_CALLE'] = 174;
            } else if($Row['CODIGO_CALLE'] == 3247) {   // Luis Garibaldi Honte
                $Row['CODIGO_CALLE'] = 285;
            } else if($Row['CODIGO_CALLE'] == 1768) {   // Obispo Trejo
                $Row['CODIGO_CALLE'] = 294;
            } else if($Row['CODIGO_CALLE'] == 1153) {   // José Hernández
                $Row['CODIGO_CALLE'] = 90;
            } else if($Row['CODIGO_CALLE'] == 1398 || $Row['CODIGO_CALLE'] == 1381) {   // Belisario Roldán
                $Row['CODIGO_CALLE'] = 173;
            } else if($Row['CODIGO_CALLE'] == 1506) {   // Tomas Roldán
                $Row['CODIGO_CALLE'] = 53;
            } else if($Row['CODIGO_CALLE'] == 718) {    // Libertad
                $Row['CODIGO_CALLE'] = 116;
            } else if($Row['CODIGO_CALLE'] == 1949) {   // Juan Bautista Thorne
                $Row['CODIGO_CALLE'] = 197;
            } else if($Row['CODIGO_CALLE'] == 857) {    // Gobernador Paz
                $Row['CODIGO_CALLE'] = 67;
            } else if($Row['CODIGO_CALLE'] == 655) {    // Estrada
                $Row['CODIGO_CALLE'] = 55;
            }
            
            
            $entity = $em->getRepository('YacareBaseBundle:Persona')->findOneBy(array(
                'Tg06100Id' => $Row['TG06100_ID']
            ));
            
            /* if($entity == null && $Cuilt) {
                $entity = $em->getRepository('YacareBaseBundle:Persona')->findOneBy(array(
                    'Cuilt' => $Cuilt
                ));
            } */
            
            if($entity == null) {
                $entity = $em->getRepository('YacareBaseBundle:Persona')->findOneBy(array(
                    /* 'DocumentoTipo' => $TipoDocs[$Documento[0]], */
                    'DocumentoNumero' => $Documento[1]
                ));
            }
            
            if($entity == null) {
                $entity = new \Yacare\BaseBundle\Entity\Persona();
                $entity->setTg06100Id($Row['TG06100_ID']);
                
                $entity->setNombre($Nombre);
                $entity->setApellido($Apellido);
                //$entity->setRazonSocial($RazonSocial);
                $entity->setPersonaJuridica($PersJur);
                $entity->setDocumentoNumero($Documento[1]);
                $entity->setDomicilioCodigoPostal('9420');
                if($Row['CODIGO_CALLE']) {
                    $entity->setDomicilioCalle($em->getReference('YacareCatastroBundle:Calle', $Row['CODIGO_CALLE']));
                }
                $entity->setDomicilioCalleNombre(StringHelper::Desoraclizar($Row['CALLE']));
                $entity->setDomicilioNumero($Row['NUMERO']);
                $entity->setDomicilioPiso($Row['PISO']);
                $entity->setDomicilioPuerta($Row['DEPARTAMENTO']);
                $entity->setGrupos(new \Doctrine\Common\Collections\ArrayCollection(array($em->getReference('YacareBaseBundle:PersonaGrupo', 3))));
                if($Row['Q_SEXO'] == 'F') {
                    $entity->setGenero(1);
                }
                if($Cuilt) {
                    $entity->setCuilt ($Cuilt);
                }
            
                $em->persist($entity);
                $importar_importados++;
            } else {
                $entity->setTg06100Id($Row['TG06100_ID']);
                //$entity->setRazonSocial($RazonSocial);
                $importar_actualizados++;
            }
            
            // Campos que se actualizan siempre
            $entity->setDocumentoTipo($TipoDocs[$Documento[0]]);


            $log[] = $Cuilt . ' / ' . $Documento[0] . ' ' . $Documento[1] . ': ' . $NombreVisible . "\r\n";
            $importar_procesados++;
            
            $em->flush();

            if(($importar_procesados % 100) == 0) {
                ob_flush();
                flush();
                
                $em->getConnection()->commit();
                $em->getConnection()->beginTransaction();
            }
        }
        
        ob_flush();
        flush();
        
        $em->getConnection()->commit();
        
        return array(
            'importar_importados' => $importar_importados,
            'importar_actualizados' => $importar_actualizados,
            'importar_procesados' => $importar_procesados,
            'redir_desde' => ($importar_procesados == $cant ? $desde + $cant : 0),
            'log' => $log
            );
    }
    
    
    
    
    
    
    
    
    
    
    
    /**
     * @Route("calles/")
     * @Template("YacareSigemiBundle:Importar:importar.html.twig")
     */
    public function importarCallesAction()
    {
        mb_internal_encoding('UTF-8');
        ini_set('display_errors', 1);
        
        $em = $this->getDoctrine()->getManager();

        $Dbmunirg = $this->ConectarOracle();
        
        $importar_importados = 0;
        $importar_actualizados = 0;
        $importar_procesados = 0;
        $log = array();
        foreach($Dbmunirg->query('SELECT CODIGO_CALLE AS id, CALLE AS Nombre FROM TG06405 WHERE TG06403_TG06403_ID=410') as $Row) {
            $nombreBueno = StringHelper::Desoraclizar($Row['NOMBRE']);
            
            $entity = $em->getRepository('YacareCatastroBundle:Calle')->findOneBy(array(
                'ImportSrc' => 'dbmunirg.TG06405',
                'ImportId' => $Row['ID']
             ));
            
            if(!$entity) {
                $entity = $em->getRepository('YacareCatastroBundle:Calle')->findOneBy(array(
                    'Nombre' => $nombreBueno
                ));
            }
            
            if(!$entity) {
                $entity = new \Yacare\CatastroBundle\Entity\Calle();
                $importar_importados++;
            } else {
                $importar_actualizados++;
            }
            
            $entity->setNombre($nombreBueno);
            $entity->setImportSrc('dbmunirg.TG06405');
            $entity->setImportId($Row['ID']);
            $entity->setNombreOriginal($Row['NOMBRE']);

            $em->persist($entity);
            $em->flush();
            
            $importar_procesados++;
            $log[] = $Row['ID'] . ' ' . $nombreBueno;
        }
        
        return array(
            'importar_importados' => $importar_importados,
            'importar_actualizados' => $importar_actualizados,
            'importar_procesados' => $importar_procesados,
            'log' => $log
            );
    }
    
    
    
    
    
    
    
    
    
    
    
    /**
     * @Route("departamentos/")
     * @Template("YacareSigemiBundle:Importar:importar.html.twig")
     */
    public function importarDepartamentosAction()
    {
        mb_internal_encoding('UTF-8');
        ini_set('display_errors', 1);
        
        $em = $this->getDoctrine()->getManager();

        $DbRecursos = $this->ConectarRrhh();
        
        $importar_importados = 0;
        $importar_actualizados = 0;
        $importar_procesados = 0;
        $log = array();
        
        $Ejecutivo = $em->getRepository('YacareOrganizacionBundle:Departamento')->find(1);

        foreach($DbRecursos->query('SELECT * FROM secretarias WHERE codigo<>999') as $Row) {
            $nombreBueno = StringHelper::Desoraclizar($Row['detalle']);
            $entity = $em->getRepository('YacareOrganizacionBundle:Departamento')->findOneBy(array(
                'ImportSrc' => 'rr_hh.secretarias',
                'ImportId' => $Row['codigo']
            ));
            
            if(!$entity) {
                $entity = new \Yacare\OrganizacionBundle\Entity\Departamento();
                $entity->setNombre($nombreBueno);
                $entity->setRango(30);
                $entity->setImportSrc('rr_hh.secretarias');
                $entity->setImportId($Row['codigo']);

                $importar_importados++;
            } else {
                $importar_actualizados++;
            }

            $entity->setParentNode($Ejecutivo);
            if($Row['fecha_baja']) {
                $entity->setSuprimido(true);
            }
            
            $em->persist($entity);
            $em->flush();
            
            $importar_procesados++;
            $log[] = 'Secretaría ' . $Row['codigo'] . ' ' . $nombreBueno;
        }
        
        foreach($DbRecursos->query('SELECT * FROM direcciones WHERE secretaria<>999') as $Row) {
            $nombreBueno = StringHelper::Desoraclizar($Row['detalle']);
            $entity = $em->getRepository('YacareOrganizacionBundle:Departamento')->findOneBy(array(
                'ImportSrc' => 'rr_hh.direcciones',
                'ImportId' => $Row['secretaria'] . '.' . $Row['direccion']
            ));
            
            if(!$entity) {
                $entity = new \Yacare\OrganizacionBundle\Entity\Departamento();
                $entity->setNombre($nombreBueno);
                $entity->setRango(50);
                $entity->setImportSrc('rr_hh.direcciones');
                $entity->setImportId($Row['secretaria'] . '.' . $Row['direccion']);

                $importar_importados++;
            } else {
                $importar_actualizados++;
            }

            $Secre = $em->getRepository('YacareOrganizacionBundle:Departamento')->findOneBy(array(
                'ImportSrc' => 'rr_hh.secretarias',
                'ImportId' => $Row['secretaria']
            ));
            $entity->setParentNode($Secre);
            
            if($Row['fecha_baja']) {
                $entity->setSuprimido(true);
            }

            $em->persist($entity);
            $em->flush();
            
            $importar_procesados++;
            $log[] = 'Dirección ' . $Row['secretaria'] . '.' . $Row['direccion'] . ' ' . $nombreBueno;
        }
        
        return array(
            'importar_importados' => $importar_importados,
            'importar_actualizados' => $importar_actualizados,
            'importar_procesados' => $importar_procesados,
            'log' => $log
            );
    }
    















    /**
     * @Route("agentes/")
     * @Template("YacareSigemiBundle:Importar:importar.html.twig")
     */
    public function importarAgentesAction()
    {
        $request = $this->getRequest();
        $desde = (int)($request->query->get('desde'));
        $cant = 100;
        
        mb_internal_encoding('UTF-8');
        ini_set('display_errors', 1);
        set_time_limit(600);
        ini_set('memory_limit', '2048M');
        
        $em = $this->getDoctrine()->getManager();

        $DbRecursos = $this->ConectarRrhh();
        
        $importar_importados = 0;
        $importar_actualizados = 0;
        $importar_procesados = 0;
        $log = array();

        foreach($DbRecursos->query("SELECT * FROM agentes WHERE nrodoc>0 LIMIT $desde, $cant") as $Row) {
            $entity = $em->getRepository('YacareRecursosHumanosBundle:Agente')->findOneBy(array(
                'ImportSrc' => 'rr_hh.agentes',
                'ImportId' => $Row['legajo']
            ));
            
            if(!$entity) {
                $entity = new \Yacare\RecursosHumanosBundle\Entity\Agente();
                $entity->setId((int)($Row['legajo']));
                
                $Persona = $em->getRepository('YacareBaseBundle:Persona')->findOneBy(array(
                    'DocumentoNumero' => trim($Row['nrodoc']),
                ));
                
                if(!$Persona) {
                    $Persona = new \Yacare\BaseBundle\Entity\Persona();
                    $Persona->setDocumentoNumero($Row['nrodoc']);
                    $Persona->setDocumentoTipo((int)$Row['tipodoc']);
                }
                $Persona->setNombre(StringHelper::Desoraclizar($Row['name']));
                $Persona->setApellido(StringHelper::Desoraclizar($Row['lastname']));
                if($Row['fechanacim']) {
                    $Persona->setFechaNacimiento(new \DateTime($Row['fechanacim']));
                }
                $Persona->setTelefonoNumero(trim(str_ireplace('NO DECLARA', '', $Row['telefono']) . ' ' . str_ireplace('NO DECLARA', '', $Row['celular'])));
                $Persona->setGenero($Row['sexo'] == 1 ? 1 : 0);
                $Persona->setEmail(str_ireplace('NO DECLARA', '', strtolower($Row['email'])));
                $Persona->setCuilt(trim($Row['cuil']));

                $em->persist($Persona);
                $em->flush();
           
               $Departamento = $em->getRepository('YacareOrganizacionBundle:Departamento')->findOneBy(array(
                    'ImportSrc' => 'rr_hh.direcciones',
                    'ImportId' => $Row['secretaria'] . '.' . $Row['direccion']
                ));
                
                $entity->setPersona($Persona);
                $entity->setDepartamento($Departamento);
                $entity->setCategoria($Row['categoria']);
                $entity->setSituacion($Row['situacion']);
                $entity->setFuncion(StringHelper::Desoraclizar($Row['funcion']));
                
                $entity->setImportSrc('rr_hh.agentes');
                $entity->setImportId($Row['legajo']);

                $importar_importados++;
            } else {
                $importar_actualizados++;
            }

            if($Row['fechaingre']) {
                $entity->setFechaIngreso(new \DateTime($Row['fechaingre']));
            } else {
                $entity->setFechaIngreso(null);
            }                

            if($Row['fechabaja']) {
                $entity->setFechaBaja(new \DateTime($Row['fechabaja']));
                $entity->setSuprimido(true);
            } else {
                $entity->setFechaBaja(null);
                $entity->setSuprimido(false);
            }
            
            $em->persist($entity);
            $em->flush();
            
            $importar_procesados++;
            $log[] = $Row['legajo'] . ': ' . (string)$entity . ': ' . (string)$entity->getDepartamento();
        }
        
        return array(
            'importar_importados' => $importar_importados,
            'importar_actualizados' => $importar_actualizados,
            'importar_procesados' => $importar_procesados,
            'redir_desde' => ($importar_procesados == $cant ? $desde + $cant : 0),
            'log' => $log
            );
    }
    
    
    protected function ConectarOracle() {
                $tns = '(DESCRIPTION = 
			    (ADDRESS_LIST = 
			        (ADDRESS = 
			          (COMMUNITY = tcp.world)
			          (PROTOCOL = TCP)
			          (Host = 192.168.100.20)
			          (Port = 1521)
			        )
			    )
			    (CONNECT_DATA = (SID = dbmunirg)
			    )
			  )';
  
        return new \PDO('oci:charset=UTF8;dbname=' . $tns, 'rgr', '123');
    }
    
    
    protected function ConectarRrhh() {
        return new \PDO('mysql:host=192.168.100.5;dbname=rr_hh;charset=utf8', 'yacare', '123456');
    }
}

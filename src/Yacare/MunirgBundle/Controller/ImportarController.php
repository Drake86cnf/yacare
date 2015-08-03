<?php
namespace Yacare\MunirgBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Tapir\BaseBundle\Helper\StringHelper;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Tapir\BaseBundle\TapirBaseBundle;
use Yacare\RecursosHumanosBundle\Entity\AgenteCargoMovim;

/**
 * @Route("importar/")
 */
class ImportarController extends Controller
{

    /**
     * @Route("partidas/")
     * @Template("YacareMunirgBundle:Importar:importar.html.twig")
     */
    public function importarPartidasAction(Request $request)
    {
        // DELETE FROM Catastro_Partida WHERE id NOT IN (SELECT DISTINCT Partida_id FROM
        // Inspeccion_RelevamientoAsignacionDetalle);
        $desde = (int) ($request->query->get('desde'));
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
            'ZEIU' => null);
        
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
          tr02100.TIT_TG06100_ID,
          j.IDENTIFICACION_TRIBUTARIA,
		  doc.DOCUMENTO_NRO
     FROM tr3a100
          JOIN tr3a100\$rgr ON (tr3a100.tr3a100_id = tr3a100\$rgr.tr3a100_tr3a100_id)
          JOIN TG06300 ON (TG06300.TG06300_ID = tr3a100.TG06300_TG06300_ID)
          LEFT JOIN tr02100 ON (tr02100.tr02100_id = tr3a100.tr02100_tr02100_id)
		  LEFT JOIN TG06110 p ON tr02100.TIT_TG06100_ID = p.TG06100_TG06100_ID
		  LEFT JOIN TG06120 j ON tr02100.TIT_TG06100_ID = j.TG06100_TG06100_ID
		  LEFT JOIN TG06111 doc ON tr02100.TIT_TG06100_ID = doc.TG06110_TG06100_TG06100_ID
     WHERE tr3a100.estado='AL'
        AND tr3a100.lugar='RGR'
        AND tr02100.DEFINITIVO='D'
        AND tr02100.IMPONIBLE_TIPO='INM'

     ORDER BY tr3a100.catastro_id
) a 
    WHERE ROWNUM <=" . ($desde + $cant) . ")
WHERE rnum >" . $desde . "
";
        foreach ($Dbmunirg->query($sql) as $Row) {
            $Seccion = strtoupper(trim($Row['SECCION'], ' .'));
            $MacizoNum = trim($Row['MACIZO_NUM'], ' .');
            $MacizoAlfa = trim($Row['MACIZO_ALFA'], ' .');
            $ParcelaNum = trim($Row['PARCELA_NUM'], ' .');
            $ParcelaAlfa = trim($Row['PARCELA_ALFA'], ' .');
            $Macizo = trim($MacizoNum . $MacizoAlfa);
            $Parcela = trim($ParcelaNum . $ParcelaAlfa);
            $UnidadFuncional = (int) ($Row['UNID_FUNC']);
            
            $entity = null;
            /*
             * $entity = $em->getRepository('YacareCatastroBundle:Partida')->findOneBy(array( 'ImportSrc' =>
             * 'dbmunirg.TR3A100', 'ImportId' => $Row['TR3A100_ID'] ));
             */
            
            if (! $entity) {
                $entity = $em->getRepository('YacareCatastroBundle:Partida')->findOneBy(array(
                    'Seccion' => $Seccion,
                    'Macizo' => $Macizo,
                    'Parcela' => $Parcela,
                    'UnidadFuncional' => $UnidadFuncional));
            }
            
            if (! $entity) {
                $entity = $em->getRepository('YacareCatastroBundle:Partida')->findOneBy(array(
                    'Numero' => (int) ($Row['CATASTRO_ID'])));
            }
            
            if (! $entity) {
                $entity = new \Yacare\CatastroBundle\Entity\Partida();
                $entity->setSeccion($Seccion);
                $entity->setMacizoAlfa($MacizoAlfa);
                $entity->setMacizoNum($MacizoNum);
                $entity->setMacizo($Macizo);
                $entity->setParcelaAlfa($ParcelaAlfa);
                $entity->setParcelaNum($ParcelaNum);
                $entity->setParcela($Parcela);
                
                $importar_importados ++;
            } else {
                $importar_actualizados ++;
            }
            
            $CodigoCalle = $this->ArreglarCodigoCalle($Row['CODIGO_CALLE']);
            
            if ($entity && $Seccion) {
                if ($CodigoCalle) {
                    $entity->setDomicilioCalle($em->getReference('YacareCatastroBundle:Calle', $CodigoCalle));
                } else {
                    $entity->setDomicilioCalle(null);
                }
                
                if ($Row['ZONA_CURB']) {
                    $ZonaId = @$Zonas[$Row['ZONA_CURB']];
                    if ($ZonaId) {
                        $entity->setZona($em->getReference('YacareCatastroBundle:Zona', $ZonaId));
                    } else {
                        $entity->setZona(null);
                    }
                } else {
                    $entity->setZona(null);
                }
                
                $Row['DOCUMENTO_NRO'] = str_replace(array(
                    ' ',
                    '-',
                    '.'), '', $Row['DOCUMENTO_NRO']);
                $Row['IDENTIFICACION_TRIBUTARIA'] = str_replace(array(
                    ' ',
                    '-',
                    '.'), '', $Row['IDENTIFICACION_TRIBUTARIA']);
                
                if ($Row['TIT_TG06100_ID'] || $Row['DOCUMENTO_NRO'] || $Row['IDENTIFICACION_TRIBUTARIA']) {
                    $titular = $em->getRepository('YacareBaseBundle:Persona')->findOneBy(array(
                        'Tg06100Id' => $Row['TIT_TG06100_ID']));
                    if (! $titular && $Row['DOCUMENTO_NRO']) {
                        $titular = $em->getRepository('YacareBaseBundle:Persona')->findOneBy(array(
                            'DocumentoNumero' => $Row['DOCUMENTO_NRO']));
                        if (! $titular) {
                            $titular = $em->getRepository('YacareBaseBundle:Persona')->findOneBy(array(
                                'Cuilt' => $Row['DOCUMENTO_NRO']));
                        }
                    }
                    if (! $titular && $Row['IDENTIFICACION_TRIBUTARIA']) {
                        $titular = $em->getRepository('YacareBaseBundle:Persona')->findOneBy(array(
                            'Cuilt' => $Row['IDENTIFICACION_TRIBUTARIA']));
                        if (! $titular) {
                            $titular = $em->getRepository('YacareBaseBundle:Persona')->findOneBy(array(
                                'Cuilt' => $Row['IDENTIFICACION_TRIBUTARIA']));
                        }
                    }
                    $entity->setTitular($titular);
                    if ($titular)
                        $log[] = "titular encontrado " . $Row['TIT_TG06100_ID'] . ': ' . $titular;
                    else
                        $log[] = "titular NO encontrado " . $Row['TIT_TG06100_ID'] . ', doc ' . $Row['DOCUMENTO_NRO'] . ', it ' . $Row['IDENTIFICACION_TRIBUTARIA'];
                } else {
                    $log[] = "*** Sin titular " . $Row['TIT_TG06100_ID'];
                    $entity->setTitular(null);
                }
                
                $entity->setUnidadFuncional($UnidadFuncional, $CodigoCalle);
                $entity->setDomicilioNumero((int) ($Row['NUMERO']));
                $entity->setDomicilioPiso(trim($Row['PISO']));
                $entity->setDomicilioPuerta(trim($Row['DEPARTAMENTO']));
                $entity->setLegajo((int) ($Row['LEGAJO']));
                $entity->setNumero((int) ($Row['CATASTRO_ID']));
                
                // $entity->setImportSrc('dbmunirg.TR3A100');
                // $entity->setImportId($Row['TR3A100_ID']);
                
                $em->persist($entity);
                $em->flush();
                // $log[] = $Row['CATASTRO_ID'] . " SMP($Seccion-$Macizo-$Parcela-$UnidadFuncional) ${Row['CALLE']}
                // #${Row['NUMERO']} --- " . $entity->getTitular();
            }
            
            $importar_procesados ++;
        }
        
        $em->getConnection()->commit();
        
        return array(
            'importar_importados' => $importar_importados,
            'importar_actualizados' => $importar_actualizados,
            'importar_procesados' => $importar_procesados,
            'redir_desde' => ($importar_procesados == $cant ? $desde + $cant : 0),
            'log' => $log);
    }

    /**
     * @Route("personas/")
     * @Template("YacareMunirgBundle:Importar:importar.html.twig")
     */
    public function importarPersonasAction(Request $request, $desde = 0)
    {
        $desde = (int) ($request->query->get('desde'));
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
            'CUIT' => 99);
        
        $Dbmunirg = $this->ConectarOracle();
        
        $em = $this->getDoctrine()->getManager();
        $em->getConnection()->beginTransaction();
        
        $GrupoContribuyentes = $em->getReference('YacareBaseBundle:PersonaGrupo', 3);
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
    a.TRIBUTARIA_ID,
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
    LEFT JOIN TG06111 doc ON a.TG06100_ID = doc.TG06110_TG06100_TG06100_ID
    JOIN TR02100 imp ON a.TG06100_ID = imp.TIT_TG06100_ID
WHERE a.BAJA_MOTIVO IS NULL
    AND a.NOMBRE<>'NN'
    AND imp.IMPONIBLE_TIPO='IND' AND imp.DEFINITIVO='D'
    AND d.LOCALIDAD='RIO GRANDE' 
    AND a.NOMBRE NOT LIKE '?%'
ORDER BY a.TG06100_ID

) a 
    WHERE ROWNUM <=" . ($desde + $cant) . ")
WHERE rnum >" . $desde . "
";
        
        foreach ($Dbmunirg->query($sql) as $Row) {
            $Documento = StringHelper::ObtenerDocumento($Row['IND_IDENTIFICACION']);
            $Apellido = StringHelper::Desoraclizar($Row['Q_APELLIDOS']);
            $Nombre = StringHelper::Desoraclizar($Row['Q_NOMBRES']);
            $RazonSocial = StringHelper::Desoraclizar($Row['J_RAZON_SOCIAL']);
            $PersJur = false;
            
            if ($Documento[0] == 'CUIL' && (substr($Documento[1], 0, 3) == '30-' || substr($Documento[1], 0, 3) == '33-')) {
                $Documento[0] = 'CUIT';
                $PersJur = true;
            }
            
            if ($Row['DOCUMENTO_TIPO'] == 'DU') {
                $Row['DOCUMENTO_TIPO'] = 'DNI';
            }
            
            $Cuilt = '';
            if ($Documento[0] == 'CUIL' || $Documento[0] == 'CUIT') {
                $Cuilt = str_replace('-', '', $Documento[1]);
                if ($Row['DOCUMENTO_TIPO'] && $Row['DOCUMENTO_NRO']) {
                    $Documento[0] = $Row['DOCUMENTO_TIPO'];
                    $Documento[1] = $Row['DOCUMENTO_NRO'];
                }
            } else 
                if ($Row['DOCUMENTO_TIPO'] == 'CUIL' || $Row['DOCUMENTO_TIPO'] == 'CUIT') {
                    $Cuilt = str_replace('-', '', $Row['DOCUMENTO_NRO']);
                }
            
            if ($Documento[0] == 'CUIL') {
                $Partes = explode('-', $Documento[1]);
                if (count($Partes) == 3) {
                    $Documento[0] = 'DNI';
                    $Documento[1] = (int) ($Partes[1]);
                }
            }
            
            if (! $Documento[1]) {
                // No tengo documento, utilizo el campo TRIBUTARIA_ID
                $Documento[0] = 'DNI';
                $Partes = explode('-', $Documento[1]);
                if (count($Partes) == 3) {
                    $Documento[1] = (int) ($Partes[1]);
                } else {
                    $Documento[1] = trim($Row['TRIBUTARIA_ID']);
                }
            }
            
            if (! $Nombre && ! $Apellido) {
                $Apellido = StringHelper::Desoraclizar($Row['NOMBRE']);
            }
            
            if (! $Nombre && $Apellido && strpos($Apellido, '.') === false) {
                $a = explode(' ', $Apellido, 2)[0];
                $b = trim(substr($Apellido, strlen($a)));
                $Nombre = $b;
                $Apellido = $a;
            }
            
            if ($RazonSocial) {
                $NombreVisible = $RazonSocial;
            } else 
                if ($Nombre) {
                    $NombreVisible = $Apellido . ', ' . $Nombre;
                } else {
                    $NombreVisible = $Apellido;
                }
            
            $Row['TG06100_ID'] = (int) ($Row['TG06100_ID']);
            $CodigoCalle = $this->ArreglarCodigoCalle($Row['CODIGO_CALLE']);
            
            if (! $Cuilt) {
                $Cuilt = str_replace(array(
                    ' ',
                    '-',
                    '.'), '', $Row['J_IDENTIFICACION_TRIBUTARIA']);
            }
            
            $entity = $em->getRepository('YacareBaseBundle:Persona')->findOneBy(array(
                'Tg06100Id' => $Row['TG06100_ID']));
            
            if ($entity == null && $Cuilt) {
                $entity = $em->getRepository('YacareBaseBundle:Persona')->findOneBy(array(
                    'Cuilt' => $Cuilt));
            }
            
            if ($entity == null) {
                $entity = $em->getRepository('YacareBaseBundle:Persona')->findOneBy(array(
                    /* 'DocumentoTipo' => $TipoDocs[$Documento[0]], */
                    'DocumentoNumero' => $Documento[1]));
            }
            
            if ($entity == null) {
                $entity = new \Yacare\BaseBundle\Entity\Persona();
                $entity->setTg06100Id($Row['TG06100_ID']);
                
                $entity->setDomicilioCodigoPostal('9420');
                if ($CodigoCalle) {
                    $entity->setDomicilioCalle($em->getReference('YacareCatastroBundle:Calle', $CodigoCalle));
                }
                $entity->setDomicilioCalleNombre(StringHelper::Desoraclizar($Row['CALLE']));
                $entity->setDomicilioNumero($Row['NUMERO']);
                $entity->setDomicilioPiso($Row['PISO']);
                $entity->setDomicilioPuerta($Row['DEPARTAMENTO']);
                
                // Si no está en el grupo Contribuyentes, lo agrego
                if ($entity->getGrupos()->contains($GrupoContribuyentes) == false) {
                    $entity->getGrupos()->add($GrupoContribuyentes);
                }
                if ($Row['Q_SEXO'] == 'F') {
                    $entity->setGenero(2);
                } else 
                    if ($Row['Q_SEXO'] == 'M') {
                        $entity->setGenero(1);
                    }
                
                $em->persist($entity);
                $importar_importados ++;
            } else {
                $entity->setTg06100Id($Row['TG06100_ID']);
                // $entity->setRazonSocial($RazonSocial);
                $importar_actualizados ++;
            }
            
            $entity->setNombre($Nombre);
            $entity->setApellido($Apellido);
            $entity->setRazonSocial($RazonSocial);
            $entity->setPersonaJuridica($PersJur);
            $entity->setDocumentoNumero($Documento[1]);
            if (! $entity->getCuilt() && $Cuilt) {
                $entity->setCuilt($Cuilt);
            }
            
            // Campos que se actualizan siempre
            $entity->setDocumentoTipo($TipoDocs[$Documento[0]]);
            
            $log[] = $Cuilt . ' / ' . $Documento[0] . ' ' . $Documento[1] . ': ' . $NombreVisible . "\r\n";
            $importar_procesados ++;
            
            $em->flush();
            
            if (($importar_procesados % 100) == 0) {
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
            'log' => $log);
    }

    /**
     * @Route("calles/")
     * @Template("YacareMunirgBundle:Importar:importar.html.twig")
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
        foreach ($Dbmunirg->query('SELECT CODIGO_CALLE AS id, CALLE AS Nombre FROM TG06405 WHERE TG06403_TG06403_ID=410') as $Row) {
            $nombreBueno = StringHelper::Desoraclizar($Row['NOMBRE']);
            
            $entity = $em->getRepository('YacareCatastroBundle:Calle')->findOneBy(array(
                'ImportSrc' => 'dbmunirg.TG06405',
                'ImportId' => $Row['ID']));
            
            if (! $entity) {
                $entity = $em->getRepository('YacareCatastroBundle:Calle')->findOneBy(array(
                    'Nombre' => $nombreBueno));
            }
            
            if (! $entity) {
                $entity = new \Yacare\CatastroBundle\Entity\Calle();
                /*
                 * $entity->setId($Row['ID']); $metadata = $em->getClassMetaData(get_class($entity));
                 * $metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);
                 */
                $importar_importados ++;
            } else {
                $importar_actualizados ++;
            }
            
            $entity->setNombre($nombreBueno);
            $entity->setImportSrc('dbmunirg.TG06405');
            $entity->setImportId($Row['ID']);
            $entity->setNombreOriginal($Row['NOMBRE'] . '!!!');
            
            $em->persist($entity);
            
            $importar_procesados ++;
            $log[] = $Row['ID'] . ' ' . $nombreBueno;
        }
        $em->flush();
        
        return array(
            'importar_importados' => $importar_importados,
            'importar_actualizados' => $importar_actualizados,
            'importar_procesados' => $importar_procesados,
            'log' => $log);
    }

    /**
     * @Route("departamentos/")
     * @Template("YacareMunirgBundle:Importar:importar.html.twig")
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
        
        foreach ($DbRecursos->query('SELECT * FROM secretarias WHERE codigo<>999') as $Row) {
            $nombreBueno = StringHelper::Desoraclizar($Row['detalle']);
            $entity = $em->getRepository('YacareOrganizacionBundle:Departamento')->findOneBy(array(
                'ImportSrc' => 'rr_hh.secretarias',
                'ImportId' => $Row['codigo']));
            
            if (! $entity) {
                $nuevoId = $this->getDoctrine()
                    ->getManager()
                    ->createQuery('SELECT MAX(r.id) FROM YacareOrganizacionBundle:Departamento r')
                    ->getSingleScalarResult();
                $entity = new \Yacare\OrganizacionBundle\Entity\Departamento();
                $entity->setId(++ $nuevoId);
                $entity->setRango(30);
                $entity->setImportSrc('rr_hh.secretarias');
                $entity->setImportId($Row['codigo']);
                
                $importar_importados ++;
            } else {
                $importar_actualizados ++;
            }
            
            $entity->setNombre($nombreBueno);
            
            $entity->setParentNode($Ejecutivo);
            if ($Row['fecha_baja']) {
                $entity->setSuprimido(true);
            }
            
            $em->persist($entity);
            $em->flush();
            
            $importar_procesados ++;
            $log[] = 'Secretaría ' . $Row['codigo'] . " \t" . $nombreBueno;
        }
        
        foreach ($DbRecursos->query('SELECT * FROM direcciones WHERE secretaria<>999') as $Row) {
            $nombreBueno = StringHelper::Desoraclizar($Row['detalle']);
            $entity = $em->getRepository('YacareOrganizacionBundle:Departamento')->findOneBy(array(
                'ImportSrc' => 'rr_hh.direcciones',
                'ImportId' => $Row['secretaria'] . '.' . $Row['direccion']));
            
            if (! $entity) {
                $nuevoId = $this->getDoctrine()
                    ->getManager()
                    ->createQuery('SELECT MAX(r.id) FROM YacareOrganizacionBundle:Departamento r')
                    ->getSingleScalarResult();
                $entity = new \Yacare\OrganizacionBundle\Entity\Departamento();
                $entity->setId(++ $nuevoId);
                $entity->setRango(50);
                $entity->setImportSrc('rr_hh.direcciones');
                $entity->setImportId($Row['secretaria'] . '.' . $Row['direccion']);
                
                $importar_importados ++;
            } else {
                $importar_actualizados ++;
            }
            
            $entity->setNombre($nombreBueno);
            if ($Row['fecha_baja']) {
                $entity->setSuprimido(true);
            }
            
            $Secre = $em->getRepository('YacareOrganizacionBundle:Departamento')->findOneBy(array(
                'ImportSrc' => 'rr_hh.secretarias',
                'ImportId' => $Row['secretaria']));
            $entity->setParentNode($Secre);
            
            $em->persist($entity);
            $em->flush();
            
            $importar_procesados ++;
            $log[] = 'Dirección ' . $Row['secretaria'] . '.' . $Row['direccion'] . " \t" . $nombreBueno;
        }
        
        foreach ($DbRecursos->query('SELECT * FROM sectores') as $Row) {
            $nombreBueno = StringHelper::Desoraclizar($Row['detalle']);
            $entity = $em->getRepository('YacareOrganizacionBundle:Departamento')->findOneBy(array(
                'ImportSrc' => 'rr_hh.sectores',
                'ImportId' => $Row['secretaria'] . '.' . $Row['direccion'] . '.' . $Row['sector']));
            
            if (! $entity) {
                $nuevoId = $this->getDoctrine()
                    ->getManager()
                    ->createQuery('SELECT MAX(r.id) FROM YacareOrganizacionBundle:Departamento r')
                    ->getSingleScalarResult();
                $entity = new \Yacare\OrganizacionBundle\Entity\Departamento();
                $entity->setId(++ $nuevoId);
                $entity->setRango(70);
                $entity->setImportSrc('rr_hh.sectores');
                $entity->setImportId($Row['secretaria'] . '.' . $Row['direccion'] . '.' . $Row['sector']);
                
                $importar_importados ++;
            } else {
                $importar_actualizados ++;
            }
            
            $entity->setNombre($nombreBueno);
            
            if ($Row['fecha_baja']) {
                $entity->setSuprimido(true);
            } else {
                $entity->setSuprimido(false);
            }
            
            if ($Row['parte']) {
                $entity->setHaceParteDiario(true);
            } else {
                $entity->setHaceParteDiario(false);
            }
            
            $Dire = $em->getRepository('YacareOrganizacionBundle:Departamento')->findOneBy(array(
                'ImportSrc' => 'rr_hh.direcciones',
                'ImportId' => $Row['secretaria'] . '.' . $Row['direccion']));
            $entity->setParentNode($Dire);
            
            $em->persist($entity);
            $em->flush();
            
            $importar_procesados ++;
            $log[] = 'Sector ' . $Row['secretaria'] . '.' . $Row['direccion'] . '.' . $Row['sector'] . " \t" . $nombreBueno;
        }
        
        return array(
            'importar_importados' => $importar_importados,
            'importar_actualizados' => $importar_actualizados,
            'importar_procesados' => $importar_procesados,
            'log' => $log);
    }

    /**
     * @Route("agentes/")
     * @Template("YacareMunirgBundle:Importar:importar.html.twig")
     */
    public function importarAgentesAction(Request $request)
    {
        $desde = (int) ($request->query->get('desde'));
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
        
        $GrupoAgentes = $em->getRepository('YacareBaseBundle:PersonaGrupo')->find(1);
        
        foreach ($DbRecursos->query("SELECT * FROM agentes WHERE legajo= 3236") as $Agente) {
            $entity = $em->getRepository('YacareRecursosHumanosBundle:Agente')->findOneBy(array(
                'ImportSrc' => 'rr_hh.agentes',
                'ImportId' => $Agente['legajo']));
            
            if (! $entity) {
                $entity = new \Yacare\RecursosHumanosBundle\Entity\Agente();
                
                // Asigno manualmente el ID
                $entity->setId((int) ($Agente['legajo']));
                $metadata = $em->getClassMetaData(get_class($entity));
                $metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);
                
                $Persona = $em->getRepository('YacareBaseBundle:Persona')->findOneBy(array(
                    'DocumentoNumero' => trim($Agente['nrodoc'])));
                
                if (! $Persona) {
                    $Persona = new \Yacare\BaseBundle\Entity\Persona();
                    $Persona->setDocumentoNumero($Agente['nrodoc']);
                    $Persona->setDocumentoTipo((int) $Agente['tipodoc']);
                }
                $Persona->setNombre(StringHelper::Desoraclizar($Agente['name']));
                $Persona->setApellido(StringHelper::Desoraclizar($Agente['lastname']));
                if ($Agente['fechanacim']) {
                    $Persona->setFechaNacimiento(new \DateTime($Agente['fechanacim']));
                }
                $Persona->setTelefonoNumero(trim(str_ireplace('NO DECLARA', '', $Agente['telefono']) . ' ' . str_ireplace('NO DECLARA', '', $Agente['celular'])));
                $Persona->setGenero($Agente['sexo'] == 1 ? 1 : 0);
                $Persona->setEmail(str_ireplace('NO DECLARA', '', strtolower($Agente['email'])));
                $Persona->setCuilt(trim($Agente['cuil']));
                
                $em->persist($Persona);
                $em->flush();
                
                $entity->setPersona($Persona);
                
                $entity->setImportSrc('rr_hh.agentes');
                $entity->setImportId($Agente['legajo']);
                
                $importar_importados ++;
            } else {
                $Persona = $entity->getPersona();
                $importar_actualizados ++;
            }
            
            $Departamento = $em->getRepository('YacareOrganizacionBundle:Departamento')->findOneBy(array(
                'ImportSrc' => 'rr_hh.sectores',
                'ImportId' => $Agente['secretaria'] . '.' . $Agente['direccion'] . '.' . $Agente['sector']));
            
            if (! $Departamento) {
                $Departamento = $em->getRepository('YacareOrganizacionBundle:Departamento')->findOneBy(array(
                    'ImportSrc' => 'rr_hh.direcciones',
                    'ImportId' => $Agente['secretaria'] . '.' . $Agente['direccion']));
            }
            
            if (! $Departamento) {
                $Departamento = $em->getRepository('YacareOrganizacionBundle:Departamento')->findOneBy(array(
                    'ImportSrc' => 'rr_hh.secretarias',
                    'ImportId' => $Agente['secretaria']));
            }
            
            $entity->setDepartamento($Departamento);
            $entity->setCategoria($Agente['categoria']);
            $entity->setSituacion($Agente['situacion']);
            $entity->setFuncion(StringHelper::Desoraclizar($Agente['funcion']));
            $entity->setBajaMotivo($Agente['motivo']);
            
            if ($Agente['excombatie'] == 'S') {
                $entity->setExCombatiente(1);
            }
            
            if ($Agente['discapacit'] == 'S') {
                $entity->setDiscapacitado(1);
            }
            
            if ($Agente['manohabil'] == 'I') {
                $entity->setManoHabil(1);
            }
            
            $entity->setEstudiosNivel($Agente['estudios']);
            if ($Agente['titulo'] == 999) {
                $entity->setEstudiosTitulo(null);
            } else {
                $entity->setEstudiosTitulo($Agente['titulo']);
            }
            
            // Si no está en el grupo agentes, lo agrego
            if ($Persona->getGrupos()->contains($GrupoAgentes) == false) {
                $Persona->getGrupos()->add($GrupoAgentes);
                $em->persist($Persona);
            }
            
            // Le pongo el número de legajo en la persona
            if ($entity->getId()) {
                $Persona->setAgenteId($entity->getId());
            }
            
            if ($Agente['fechaingre']) {
                $entity->setFechaIngreso(new \DateTime($Agente['fechaingre']));
            } else {
                $entity->setFechaIngreso(null);
            }
            
            if (is_null($Agente['fechabaja']) || $Agente['fechabaja'] === '0000-00-00') {
                $entity->setBajaFecha(null);
                $entity->setArchivado(false);
            } else {
                $entity->setBajaFecha(new \DateTime($Agente['fechabaja']));
                $entity->setArchivado(true);
            }
            
            if (is_null($Agente['fechanacion'] || $Agente['fechanacion'] === '0000-00-00')) {
                $entity->setFechaNacionalizacion(null);
            } else {
                $entity->setFechaNacionalizacion(new \DateTime($Agente['fechanacion']));
            }
            
            if (is_null($Agente['ult_act_d'] || $Agente['ult_act_d'] === '0000-00-00')) {
                $entity->setUltimaActualizacionDomicilio(null);
            } else {
                $entity->setUltimaActualizacionDomicilio(new \DateTime($Agente['ult_act_d']));
            }
            
            if (is_null($Agente['fecha_psico'] || $Agente['fecha_psico'] === '0000-00-00')) {
                $entity->setFechaPsicofisico(null);
            } else {
                $entity->setFechaPsicofisico(new \DateTime($Agente['ult_act_d']));
            }
            
            if (is_null($Agente['fecha_CBC'] || $Agente['fecha_CBC'] === '0000-00-00')) {
                $entity->setFechaCertificadoBuenaConducta(null);
            } else {
                $entity->setFechaCertificadoBuenaConducta(new \DateTime($Agente['fecha_CBC']));
            }
            
            if (is_null($Agente['fecha_CAP'] || $Agente['fecha_CAP'] === '0000-00-00')) {
                $entity->setFechaCertificadoAntecedentesPenales(null);
            } else {
                $entity->setFechaCertificadoAntecedentesPenales(new \DateTime($Agente['fecha_CAP']));
            }
            
            if (is_null($Agente['fecha_CD'] || $Agente['fecha_CD'] === '0000-00-00')) {
                $entity->setFechaCertificadoDomicilio(null);
            } else {
                $entity->setFechaCertificadoDomicilio(new \DateTime($Agente['fecha_CD']));
            }
            
            if (\Tapir\BaseBundle\Helper\Cbu::EsCbuValida($Agente['cbu'])) {
                $entity->setCBUCuentaAgente($Agente['cbu']);
            }
            
            if (is_null($Agente['finalcontr'] || $Agente['finalcontr'] === '0000-00-00')) {
                $entity->setBajaFechaContrato(null);
            } else {
                $entity->setBajaFechaContrato(new \DateTime($Agente['finalcontr']));
            }
            
            if ($Agente['decreto2']) {
                $Decreto = $Agente['decreto2'];
                $entity->setBajaDecreto(\Tapir\BaseBundle\Helper\StringHelper::ArreglarDecretos($Decreto));
            }
            
            /*
             * if ($Agente['lugarnacim']) {
             * $entity->setLugarNacimiento($Agente['lugarnacim']);
             * } else {
             * $entity->setLugarNacimiento(null);
             * }
             */
            
            $entity->setSuprimido(false);
            
            $em->persist($entity);
            $em->flush();
            
            $importar_procesados ++;
            $log[] = $Agente['legajo'] . ': ' . (string) $entity . ($entity->getSuprimido() ? '*' : '') . ' -- ' . (string) $entity->getDepartamento();
        }
        
        return array(
            'importar_importados' => $importar_importados,
            'importar_actualizados' => $importar_actualizados,
            'importar_procesados' => $importar_procesados,
            'redir_desde' => ($importar_procesados == $cant ? $desde + $cant : 0),
            'log' => $log);
    }

    /**
     * @Route("categoriamovimiento/")
     * @Template("YacareMunirgBundle:Importar:importar.html.twig")
     */
    public function importarHistorialCategorias(Request $request)
    {
        $desde = (int) ($request->query->get('desde'));
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
        foreach ($DbRecursos->query("SELECT * FROM movcategorias WHERE legajo= 3236") as $MovimAgente) {
            $entity = $em->getRepository('YacareRecursosHumanosBundle:AgenteCategoriaMovim')->findOneBy(array(
                //'ImportSrc' => 'rr_hh.movcategorias',
                //'ImportId' => $MovimAgente['legajo']
                ));
            if (! $entity) {
                $entity = new \Yacare\RecursosHumanosBundle\Entity\AgenteCategoriaMovim();
                $this->Categorias($entity, $MovimAgente);
               $importar_importados ++;
            } else {
                $this->Categorias($entity, $MovimAgente);
                $importar_actualizados ++;
            }
        }
        log($MovimAgente['legajo']);
        return array(
            'importar_importados' => $importar_importados,
            'importar_actualizados' => $importar_actualizados,
            'importar_procesados' => $importar_procesados,
            //'redir_desde' => ($importar_procesados == $cant ? $desde + $cant : 0),
            'log' => $log);
        
    }

    protected function Categorias($entity, $MovimAgente)
    {
        $entity->setAgente($MovimAgente['legajo']);
        if (is_null($MovimAgente['fecha'] || $MovimAgente['fecha'] === '0000-00-00')) {
            $entity->setFecha(null);
        } else {
            $entity->setFecha(new \DateTime($MovimAgente['fecha']));
        }
        $entity->setCategoria($MovimAgente['categoria']);
        $Resultado = \Tapir\BaseBundle\Helper\StringHelper::DecifrarCategoriasAcargo($MovimAgente['tipo'], $MovimAgente['categoria']);
        if ($Resultado[0] == true) {
            $entity->setCategoria($Resultado['categoria_nueva']);
            $entity->setFecha(new \DateTime($MovimAgente['fecha']));
            $entity->setAcargo(true);
            $entity->setObs($MovimAgente['tipo']);
        } else {
            $entity->setAcargo(false);
            $entity->setObs($MovimAgente['tipo']);
        }
    }

    protected function ConectarOracle()
    {
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

    protected function ConectarRrhh()
    {
        return new \PDO('mysql:host=192.168.100.5;dbname=rr_hh;charset=utf8', 'yacare', 'L1n4j3');
    }

    protected function ArreglarNombreCalle($nombreCalle)
    {
        switch ($nombreCalle) {
            case 'D\'Agostini':
                return 'Reverendo Padre Alberto D\'Agostini';
                break;
            case 'Juaretche':
                return 'Arturo Jauretche';
                break;
            case '':
                return '';
                break;
            case '':
                return '';
                break;
            case '':
                return '';
                break;
            case '':
                return '';
                break;
            case '':
                return '';
                break;
            case '':
                return '';
                break;
            case '':
                return '';
                break;
            case '':
                return '';
                break;
            case '':
                return '';
                break;
            case '':
                return '';
                break;
            case '':
                return '';
                break;
            default:
                return $nombreCalle;
                break;
        }
    }

    protected function ArreglarCodigoCalle($codigoCalle)
    {
        // Arreglar errores conocidos
        // O algunas calles que están duplicadas en SIGEMI (Isla Soledad con ids 85 y 354)
        // y que en Yacaré ingresan una sola vez.
        if ($codigoCalle == 380) {
            return null; // No existe
        } elseif ($codigoCalle == 384) { // Santa María Dominga Mazzarello
            return 389; // Este es el código correcto
        } elseif ($codigoCalle == 454) { // Juana Manuela Gorriti
            return 249;
        } elseif ($codigoCalle == 1482) { // General Villegas
            return 211;
        } elseif ($codigoCalle == 724) { // Remolcador Guaraní
            return 69;
        } elseif ($codigoCalle == 567) { // Neuquén
            return 144;
        } elseif ((int) ($codigoCalle) == 0 || $codigoCalle == 1748) { // ???
            return null;
        } elseif ($codigoCalle == 1157) { // 25 de Mayo
            return 224;
        } elseif ($codigoCalle == 474) { // Rosales
            return 174;
        } elseif ($codigoCalle == 3247) { // Luis Garibaldi Honte
            return 285;
        } elseif ($codigoCalle == 1768) { // Obispo Trejo
            return 294;
        } elseif ($codigoCalle == 1153) { // José Hernández
            return 90;
        } elseif ($codigoCalle == 1398 || $codigoCalle == 1381) { // Belisario Roldán
            return 173;
        } elseif ($codigoCalle == 1506) { // Tomas Roldán
            return 53;
        } elseif ($codigoCalle == 718) { // Libertad
            return 116;
        } elseif ($codigoCalle == 1949) { // Juan Bautista Thorne
            return 197;
        } elseif ($codigoCalle == 857) { // Gobernador Paz
            return 67;
        } elseif ($codigoCalle == 655) { // Estrada
            return 55;
        } elseif ($codigoCalle == 354) { // Estrada
            return 85;
        } elseif ($codigoCalle == 2451) { // Mariano Moreno
            return 251;
        } else {
            return (int) ($codigoCalle);
        }
    }

    /**
     * @Route("matriculados/")
     * @Template("YacareMunirgBundle:Importar:importar.html.twig")
     */
    public function importarMatriculadosAction(Request $request)
    {
        $desde = (int) ($request->query->get('desde'));
        $cant = 100;
        
        mb_internal_encoding('UTF-8');
        ini_set('display_errors', 1);
        set_time_limit(600);
        ini_set('memory_limit', '2048M');
        
        $em = $this->getDoctrine()->getManager();
        
        $ArchivoMatriculados = fopen('MatriculadosFusion.csv', 'r');
        
        $importar_importados = 0;
        $importar_actualizados = 0;
        $importar_procesados = 0;
        $log = array();
        
        $GrupoMatriculados = $em->getRepository('YacareBaseBundle:PersonaGrupo')->find(4);
        
        while (! feof($ArchivoMatriculados)) {
            $Row = fgetcsv($ArchivoMatriculados);
            
            if ($Row && count($Row) > 1 && $Row[0]) {
                $entity = $em->getRepository('YacareObrasParticularesBundle:Matriculado')->find($Row[0]);
                
                if (! $entity) {
                    $entity = new \Yacare\ObrasParticularesBundle\Entity\Matriculado();
                    
                    // Asigno manualmente el ID
                    $entity->setId((int) ($Row[0]));
                    $metadata = $em->getClassMetaData(get_class($entity));
                    $metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);
                    
                    $Persona = $em->getRepository('YacareBaseBundle:Persona')->findOneBy(array(
                        'DocumentoNumero' => trim($Row[1])));
                    
                    if (! $Persona) {
                        $Persona = new \Yacare\BaseBundle\Entity\Persona();
                        $Persona->setDocumentoNumero($Row[1]);
                        $Persona->setDocumentoTipo(1);
                        
                        $log[] = 'Creando persona: DNI ' . $Row[1] . ', ' . $Row[2];
                    }
                    
                    $entity->setPersona($Persona);
                    
                    $importar_importados ++;
                } else {
                    $Persona = $entity->getPersona();
                    $importar_actualizados ++;
                }
                
                $ApellidoYNombres = StringHelper::ObtenerApellidoYNombres($Row[2]);
                
                $PartesDomicilio = StringHelper::ObtenerCalleYNumero($Row[3]);
                
                /*
                 * $Calle = $em->getRepository ( 'YacareCatastroBundle:Calle' )->findOneBy ( array (
                 * 'Nombre' => $this->ArreglarNombreCalle ( $PartesDomicilio [0] )
                 * ) );
                 */
                
                $Calles = $em->getRepository('YacareCatastroBundle:Calle')
                    ->createQueryBuilder('c')
                    ->where('c.Nombre LIKE :nombre')
                    ->setParameter('nombre', $this->ArreglarNombreCalle($PartesDomicilio[0]))
                    ->getQuery()
                    ->getResult();
                
                if (count($Calles) == 1) {
                    $Calle = $Calles[0];
                }
                
                if (! $Calle) {
                    $log[] = 'No existe la calle ' . $PartesDomicilio[0];
                }
                
                $Persona->setDomicilioCalle($Calle);
                $Persona->setDomicilioCalleNombre($PartesDomicilio[0]);
                $Persona->setDomicilioNumero($PartesDomicilio[1]);
                if (count($PartesDomicilio) > 2) {
                    $Persona->setDomicilioPuerta($PartesDomicilio[2]);
                }
                
                $Persona->setApellido(StringHelper::Desoraclizar($ApellidoYNombres[0]));
                $Persona->setNombre(StringHelper::Desoraclizar($ApellidoYNombres[1]));
                $Persona->setTelefonoNumero(trim($Row[5]));
                $Persona->setEmail(trim($Row[6]));
                
                $em->persist($Persona);
                $em->flush();
                
                switch ($Row[4]) {
                    case 'Arquitecto':
                    case 'Artquitecto':
                    case 'Arquiteto':
                        $Profesion = 'Arquitecto';
                        break;
                    case 'M.M. Obras':
                    case 'M.M Obras':
                    case 'M.M. Obra':
                    case 'M.M. Obrasº':
                    case 'M.M.Obras':
                        $Profesion = 'Maestro mayor de obras';
                        break;
                    case 'Ing. Construcc':
                    case 'Ing.Construcciones':
                    case 'Ing. Construcciones':
                        $Profesion = 'Ingeniero en construcciones';
                        break;
                    case 'Ing. Civil':
                    case 'Ing.Civil':
                        $Profesion = 'Ingeniero civil';
                        break;
                    case 'T. Constructor':
                        $Profesion = 'Técnico constructor';
                        break;
                    default:
                        $Profesion = '???';
                        break;
                }
                
                $entity->setProfesion($Profesion);
                
                if ($Row[7]) {
                    $fecha = \DateTime::createFromFormat('Y-m-d', $Row[7]);
                    $entity->setFechaVencimiento($fecha);
                } else {
                    $entity->setFechaVencimiento(null);
                }
                
                // Si no está en el grupo agentes, lo agrego
                if ($Persona->getGrupos()->contains($GrupoMatriculados) == false) {
                    $Persona->getGrupos()->add($GrupoMatriculados);
                    $em->persist($Persona);
                }
                
                $em->persist($entity);
                $em->flush();
                
                $importar_procesados ++;
                $log[] = $Row[0] . ': ' . (string) $entity . ' (' . $entity->getProfesion() . ')';
            }
        }
        
        fclose($ArchivoMatriculados);
        
        return array(
            'importar_importados' => $importar_importados,
            'importar_actualizados' => $importar_actualizados,
            'importar_procesados' => $importar_procesados,
            'redir_desde' => ($importar_procesados == $cant ? $desde + $cant : 0),
            'log' => $log);
    }

    /**
     * @Route("badabum/")
     * @Template("YacareMunirgBundle:Importar:importar.html.twig")
     */
    public function importarBadabumAction(Request $request)
    {
        $desde = (int) ($request->query->get('desde'));
        $cant = 500;
        
        mb_internal_encoding('UTF-8');
        ini_set('display_errors', 1);
        set_time_limit(600);
        ini_set('memory_limit', '2048M');
        
        $em = $this->getDoctrine()->getManager();
        
        $ArchivoCsv = fopen('badaum.csv', 'r');
        
        $importar_importados = 0;
        $importar_actualizados = 0;
        $importar_procesados = 0;
        $log = array();
        
        for ($i = 0; $i < $desde; $i ++) {
            fgetcsv($ArchivoCsv);
        }
        
        while (! feof($ArchivoCsv)) {
            $Row = fgetcsv($ArchivoCsv);
            
            if ($Row && count($Row) > 1 && $Row[0]) {
                $Persona = $em->getRepository('YacareBaseBundle:Persona')->findOneBy(array(
                    'DocumentoNumero' => trim($Row[0])));
                
                if (! $Persona) {
                    $Persona = new \Yacare\BaseBundle\Entity\Persona();
                    $Persona->setDocumentoNumero($Row[0]);
                    $Persona->setDocumentoTipo(1);
                    
                    $ApellidoYNombres = StringHelper::ObtenerApellidoYNombres($Row[1]);
                    $Persona->setApellido(StringHelper::Desoraclizar($ApellidoYNombres[0]));
                    $Persona->setNombre(StringHelper::Desoraclizar($ApellidoYNombres[1]));
                    
                    $log[] = 'Creando persona: DNI ' . $Row[0] . ', ' . $Row[1];
                    
                    $importar_importados ++;
                } else {
                    
                    $importar_actualizados ++;
                }
                
                $PartesDomicilio = StringHelper::ObtenerCalleYNumero($Row[2]);
                
                /*
                 * $Calle = $em->getRepository ( 'YacareCatastroBundle:Calle' )->findOneBy ( array (
                 * 'Nombre' => $this->ArreglarNombreCalle ( $PartesDomicilio [0] )
                 * ) );
                 */
                
                $Calles = $em->getRepository('YacareCatastroBundle:Calle')
                    ->createQueryBuilder('c')
                    ->where('c.Nombre LIKE :nombre')
                    ->setParameter('nombre', $this->ArreglarNombreCalle($PartesDomicilio[0]))
                    ->getQuery()
                    ->getResult();
                
                if (count($Calles) == 1) {
                    $Calle = $Calles[0];
                    $PartesDomicilio[0] = $Calle->getNombre();
                } else {
                    $Calle = null;
                }
                
                if ($Row[3]) {
                    $PartesDomicilio[1] = $Row[3];
                }
                
                if ($Row[4]) {
                    $PartesDomicilio[2] = $Row[4];
                }
                
                if (! $Calle) {
                    $log[] = 'No existe la calle ' . $PartesDomicilio[0];
                }
                
                $Persona->setDomicilioCalle($Calle);
                $Persona->setDomicilioCalleNombre($PartesDomicilio[0]);
                $Persona->setDomicilioNumero($PartesDomicilio[1]);
                if (count($PartesDomicilio) > 2) {
                    $Persona->setDomicilioPuerta($PartesDomicilio[2]);
                }
                
                if (! $Persona->getTelefonoNumero()) {
                    $Persona->setTelefonoNumero(trim($Row[6]));
                } else {
                    $Persona->setTelefonoNumero($Persona->getTelefonoNumero() . ', ' . trim($Row[6]));
                }
                
                if ((! $Persona->getFechaNacimiento()) && $Row[7]) {
                    $fecha = \DateTime::createFromFormat('d/m/Y', $Row[7]);
                    if ($fecha) {
                        $Persona->setFechaNacimiento($fecha);
                    }
                }
                
                // Si no está en el grupo, lo agrego
                if ($Row[8]) {
                    $Grupo = $em->getRepository('YacareBaseBundle:PersonaGrupo')->find($Row[8]);
                    if ($Persona->getGrupos()->contains($Grupo) == false) {
                        $Persona->getGrupos()->add($Grupo);
                    }
                }
                
                $em->persist($Persona);
                $em->flush();
                
                $importar_procesados ++;
                $log[] = $Row[0] . ': ' . (string) $Persona;
            }
            
            if ($importar_procesados >= $cant) {
                break;
            }
        }
        
        fclose($ArchivoCsv);
        
        return array(
            'importar_importados' => $importar_importados,
            'importar_actualizados' => $importar_actualizados,
            'importar_procesados' => $importar_procesados,
            'redir_desde' => ($importar_procesados == $cant ? $desde + $cant : 0),
            'log' => $log);
    }
}

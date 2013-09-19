<?php

namespace Yacare\SigemiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Yacare\BaseBundle\Helper\StringHelper;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ImportarController extends Controller
{
    /**
     * @Route("/importar/personas/")
     * @Template("YacareSigemiBundle:Importar:importar.html.twig")
     */
    public function importarPersonasAction()
    {
        mb_internal_encoding('UTF-8');
        set_time_limit(6000);
        ini_set('display_errors', 1);
        ini_set('memory_limit', '2048M');
        
        $response = new StreamedResponse();
        $response->setCallback(function () {
        
        echo '<pre>';
            
        $TipoDocs = array(
            'DNI' => 1,
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
        $importar_procesados = 0;
        $log = array();
        foreach($Dbmunirg->query("SELECT
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
FROM TG06100X a,
    TG06110 p,
    TG06120 j,
    TG06300 d,
    TG06111 doc,
    TR02100 imp
WHERE a.TG06100_ID = p.TG06100_TG06100_ID (+)
    AND a.TG06100_ID = j.TG06100_TG06100_ID (+)
    AND a.TG06300_TG06300_ID = d.TG06300_ID (+)
    AND a.TG06100_ID = doc.TG06110_TG06100_TG06100_ID
    AND a.TG06100_ID = imp.TIT_TG06100_ID
    AND a.BAJA_MOTIVO IS NULL
    AND a.NOMBRE<>'NN'
    AND imp.IMPONIBLE_TIPO='IND' AND imp.DEFINITIVO<>'B'
    AND d.LOCALIDAD='RIO GRANDE'
    AND a.NOMBRE NOT LIKE '?%'
    AND LENGTH(doc.DOCUMENTO_NRO) > 5
") as $Row) {
            
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
            
            if($Row['DOCUMENTO_TIPO'] == 'DU')
                $Row['DOCUMENTO_TIPO'] = 'DNI';
            
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
            
            if(!$Nombre && !$Apellido)
                $Apellido = StringHelper::Desoraclizar($Row['NOMBRE']);
            
            if($RazonSocial)
                $NombreVisible = $RazonSocial;
            else if($Nombre)
                $NombreVisible = $Apellido . ', ' . $Nombre;
            else
                $NombreVisible = $Apellido;
            
            $Row['TG06100_ID'] = (int)($Row['TG06100_ID']);
            
            // Arreglar errores conocidos
            if($Row['CODIGO_CALLE'] == 380)
                $Row['CODIGO_CALLE'] = null;
            
            
            $entity = $em->getRepository('YacareBaseBundle:Persona')->findOneBy(array(
                'ImportSrc' => 'dbmunirg.TG06100',
                'ImportId' => $Row['TG06100_ID']
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
                $entity->setImportSrc('dbmunirg.TG06100');
                $entity->setImportId($Row['TG06100_ID']);
                
                $entity->setNombre($Nombre);
                $entity->setApellido($Apellido);
                $entity->setPersonaJuridica($PersJur);
                $entity->setDocumentoTipo($TipoDocs[$Documento[0]]);
                $entity->setDocumentoNumero($Documento[1]);
                $entity->setDomicilioCodigoPostal('9420');
                if($Row['CODIGO_CALLE'])
                    $entity->setDomicilioCalle($em->getReference('YacareCatastroBundle:Calle', $Row['CODIGO_CALLE']));
                $entity->setDomicilioCalleNombre(StringHelper::Desoraclizar($Row['CALLE']));
                $entity->setDomicilioNumero($Row['NUMERO']);
                $entity->setDomicilioPiso($Row['PISO']);
                $entity->setDomicilioPuerta($Row['DEPARTAMENTO']);
                if($Row['Q_SEXO'] == 'F')
                    $entity->setGenero(1);
                if($Cuilt)
                    $entity->setCuilt ($Cuilt);
            
                $em->persist($entity);
                $importar_importados++;
            } else {
                echo '*';
            }
            

            echo $Cuilt . ' / ' . $Documento[0] . ' ' . $Documento[1] . ': ' . $NombreVisible . "\r\n";
            $importar_procesados++;
            
            if($importar_procesados >= 100000)
                break;
            
            $entity->setGrupos(new \Doctrine\Common\Collections\ArrayCollection(array($em->getReference('YacareBaseBundle:PersonaGrupo', 3))));
            $em->flush();

            if(($importar_procesados % 1000) == 0) {
                ob_flush();
                flush();
                
                $em->getConnection()->commit();
                $em->getConnection()->beginTransaction();
            }
        }
        
        ob_flush();
        flush();
        
        $em->getConnection()->commit();
        
        });

        return $response;
        
        return array(
            'importar_importados' => $importar_importados,
            'importar_procesados' => $importar_procesados,
            'log' => $log
            );
    }
    
    
    /**
     * @Route("/importar/calles/")
     * @Template("YacareSigemiBundle:Importar:importar.html.twig")
     */
    public function importarCallesAction()
    {
        mb_internal_encoding('UTF-8');
        ini_set('display_errors', 1);
        
        $em = $this->getDoctrine()->getManager();

        $Dbmunirg = $this->ConectarOracle();
        
        $importar_importados = 0;
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
            }
            
            $entity->setNombre($nombreBueno);
            $entity->setImportSrc('dbmunirg.TG06405');
            $entity->setImportId($Row['ID']);
            $entity->setNombreOriginal($Row['NOMBRE']);

            $em->persist($entity);
            
            $importar_procesados++;
            $log[] = $Row['ID'] . ' ' . $nombreBueno;
        }
        
        $em->flush();
        
        return array(
            'importar_importados' => $importar_importados,
            'importar_procesados' => $importar_procesados,
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
}

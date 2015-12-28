<?php
namespace Yacare\MunirgBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Tapir\BaseBundle\Helper\StringHelper;
use Yacare\MunirgBundle\Helper\Importador\ImportadorCalles;
use Yacare\MunirgBundle\Helper\Importador\ImportadorPartidas;
use Yacare\MunirgBundle\Helper\Importador\ImportadorPersonas;
use Yacare\MunirgBundle\Helper\Importador\ImportadorActividades;

/**
 * Controlador para importar datos de otras DB, a la DB de Yacaré.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 * @author Ezequiel Riquelme <rezequiel.tdf@gmail.com>
 * @author Alejandro Díaz <alediaz.rc@gmail.com>
 * 
 * @Route("importar/")
 */
class ImportarController extends \Tapir\BaseBundle\Controller\BaseController
{
    use \Yacare\MunirgBundle\Helper\Importador\ConConexionAOracle;

    /**
     * @Route("partidas/")
     * @Template("YacareMunirgBundle:Importar:importar.html.twig")
     */
    public function importarPartidasAction(Request $request)
    {
        $iniciar = (int) ($request->query->get('iniciar'));
        if ($iniciar) {
            $desde = (int) ($request->query->get('desde'));
            $cantidad = 100;
            
            $importador = new ImportadorPartidas($this->container, $this->getDoctrine()->getManager());
            $importador->Inicializar();
            $resultado = $importador->Importar($desde, $cantidad);
            
            return $this->ArrastrarVariables($request, 
                array(
                    'importando' => 'partidas', 
                    'url' => 'importarpartidas', 
                    'resultado' => $resultado, 
                    'cantidad' => $cantidad));
        } else {
            return $this->ArrastrarVariables($request, array('importando' => 'partidas', 'url' => 'importarpartidas'));
        }
    }

    /**
     * @Route("calles/")
     * @Template("YacareMunirgBundle:Importar:importar.html.twig")
     */
    public function importarCallesAction(Request $request)
    {
        $iniciar = (int) ($request->query->get('iniciar'));
        if ($iniciar) {
            $desde = (int) ($request->query->get('desde'));
            $cantidad = 100;
            
            $importador = new ImportadorCalles($this->container, $this->getDoctrine()->getManager());
            $importador->Inicializar();
            $resultado = $importador->Importar($desde, $cantidad);
            
            return $this->ArrastrarVariables($request, 
                array(
                    'importando' => 'calles', 
                    'cantidad' => $cantidad, 
                    'url' => 'importarcalles', 
                    'resultado' => $resultado));
        } else {
            return $this->ArrastrarVariables($request, array('importando' => 'calles', 'url' => 'importarcalles'));
        }
    }

    /**
     * @Route("actividades/")
     * @Template("YacareMunirgBundle:Importar:importar.html.twig")
     */
    public function importarActividadesAction(Request $request)
    {
        $iniciar = (int) ($request->query->get('iniciar'));
        if ($iniciar) {
            $desde = (int) ($request->query->get('desde'));
            $cantidad = 100;
            
            $importador = new ImportadorActividades($this->container, $this->getDoctrine()->getManager());
            $importador->Inicializar();
            $resultado = $importador->Importar($desde, $cantidad);
            
            return $this->ArrastrarVariables($request, 
                array(
                    'importando' => 'actividades', 
                    'url' => 'importaractividades', 
                    'resultado' => $resultado, 
                    'cantidad' => $cantidad));
        } else {
            return $this->ArrastrarVariables($request, 
                array('importando' => 'actividades', 'url' => 'importaractividades'));
        }
    }

    /**
     * @Route("personas/")
     * @Template("YacareMunirgBundle:Importar:importar.html.twig")
     */
    public function importarPersonasAction(Request $request)
    {
        $iniciar = (int) ($request->query->get('iniciar'));
        if ($iniciar) {
            $desde = (int) ($request->query->get('desde'));
            $cantidad = 100;
            
            $importador = new ImportadorPersonas($this->container, $this->getDoctrine()->getManager());
            $importador->Inicializar();
            $resultado = $importador->Importar($desde, $cantidad);
            
            return $this->ArrastrarVariables($request, 
                array(
                    'importando' => 'personas', 
                    'url' => 'importarpersonas', 
                    'resultado' => $resultado, 
                    'cantidad' => $cantidad));
        } else {
            return $this->ArrastrarVariables($request, array('importando' => 'personas', 'url' => 'importarpersonas'));
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
                    
                    $Persona = $em->getRepository('YacareBaseBundle:Persona')->findOneBy(
                        array('DocumentoNumero' => trim($Row[1])));
                    
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
                    // no break
                    case 'Artquitecto':
                    case 'Arquiteto':
                        $Profesion = 'Arquitecto';
                        break;
                    case 'M.M. Obras':
                    // no break
                    case 'M.M Obras':
                    case 'M.M. Obra':
                    case 'M.M. Obrasº':
                    case 'M.M.Obras':
                        $Profesion = 'Maestro mayor de obras';
                        break;
                    case 'Ing. Construcc':
                    // no break
                    case 'Ing.Construcciones':
                    case 'Ing. Construcciones':
                        $Profesion = 'Ingeniero en construcciones';
                        break;
                    case 'Ing. Civil':
                    // no break
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
        
        $res = $this->ConstruirResultado(new \Tapir\AbmBundle\Helper\Resultados\ResultadoEditarGuardarAction($this), 
            $request);
        $res->Entidad = $entity;
        $res->Actualizados = $importar_actualizados;
        $res->Importados = $importar_importados;
        $res->Procesados = $importar_procesados;
        return array('res' => $res);
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
                $Persona = $em->getRepository('YacareBaseBundle:Persona')->findOneBy(
                    array('DocumentoNumero' => trim($Row[0])));
                
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
        
        $res = $this->ConstruirResultado(new \Tapir\AbmBundle\Helper\Resultados\ResultadoEditarGuardarAction($this), 
            $request);
        $res->Entidad = $entity;
        $res->Actualizados = $importar_actualizados;
        $res->Importados = $importar_importados;
        $res->Procesados = $importar_procesados;
        return array('res' => $res);
    }

    /**
     * @Route("bomberos/")
     * @Template("YacareMunirgBundle:Importar:importar.html.twig")
     */
    public function importarBomberosAction(Request $request)
    {
        $desde = (int) ($request->query->get('desde'));
        $cant = 100;
        
        mb_internal_encoding('UTF-8');
        ini_set('display_errors', 1);
        set_time_limit(600);
        ini_set('memory_limit', '2048M');
        
        $em = $this->getDoctrine()->getManager();
        
        $ArchivoBomberos = fopen('/home/adiaz/Documentos/Bomberos.csv', 'r');
        for ($i = 0; $i < 1770; $i ++) {
            $Actividad = $em->getRepository('YacareComercioBundle:Actividad')->findOneBy(array('NivelRiesgo' => 1));
            if ($Actividad) {
                $Actividad->setNivelRiesgo(2);
                $em->persist($Actividad);
                $em->flush();
            }
        }
        
        $importar_importados = 0;
        $importar_actualizados = 0;
        $importar_procesados = 0;
        
        while (! feof($ArchivoBomberos)) {
            $Row = fgetcsv($ArchivoBomberos);
            
            if ($Row && count($Row) > 0 && $Row[0] != null) {
                $entity = $em->getRepository('YacareComercioBundle:Actividad')->findOneBy(array('ClaeAfip' => $Row[0]));
                if ($entity) {
                    $entity->setNivelRiesgo(0);
                    $importar_actualizados ++;
                    $importar_importados ++;
                    $em->persist($entity);
                    $em->flush();
                }
                $importar_procesados ++;
            }
        }
        
        feof($ArchivoBomberos);
        
        $res = $this->ConstruirResultado(new \Tapir\AbmBundle\Helper\Resultados\ResultadoEditarGuardarAction($this), 
            $request);
        $res->Entidad = $entity;
        $res->Actualizados = $importar_actualizados;
        $res->Importados = $importar_importados;
        $res->Procesados = $importar_procesados;
        return array('res' => $res);
    }

    /**
     * @Route("ecologia/")
     * @Template("YacareMunirgBundle:Importar:importar.html.twig")
     */
    public function importarEcologiaAction(Request $request)
    {
        $desde = (int) ($request->query->get('desde'));
        $cant = 100;
        
        mb_internal_encoding('UTF-8');
        ini_set('display_errors', 1);
        set_time_limit(600);
        ini_set('memory_limit', '2048M');
        
        $em = $this->getDoctrine()->getManager();
        
        $ArchivoEcologia = fopen('/home/adiaz/Documentos/Ecologia.csv', 'r');
        
        $importar_importados = 0;
        $importar_actualizados = 0;
        $importar_procesados = 0;
        $Etiqueta = $em->getRepository('YacareComercioBundle:ActividadEtiqueta')->findOneBy(
            array('Codigo' => 'req_cat_ecologica'));
        while (! feof($ArchivoEcologia)) {
            $Row = fgetcsv($ArchivoEcologia);
            
            if ($Row && count($Row) > 0 && $Row[0] != null) {
                $entity = $em->getRepository('YacareComercioBundle:Actividad')->findOneBy(array('ClaeAfip' => $Row[0]));
                if ($entity) {
                    if (! $entity->getEtiquetas($Etiqueta)) {
                        $entity->getEtiquetas()->add($Etiqueta);
                    }
                    $importar_actualizados ++;
                    $importar_importados ++;
                    $em->persist($entity);
                    $em->flush();
                }
                $importar_procesados ++;
            }
        }
        
        feof($ArchivoEcologia);
        
        $res = $this->ConstruirResultado(new \Tapir\AbmBundle\Helper\Resultados\ResultadoEditarGuardarAction($this), 
            $request);
        $res->Entidad = $entity;
        $res->Actualizados = $importar_actualizados;
        $res->Importados = $importar_importados;
        $res->Procesados = $importar_procesados;
        return array('res' => $res);
    }
}

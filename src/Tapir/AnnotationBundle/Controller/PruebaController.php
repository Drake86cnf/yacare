<?php
namespace Tapir\AnnotationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

// Dependencias para la primera prueba de Annotation personalizada
use Doctrine\Common\Annotations\AnnotationReader;
use Tapir\AnnotationBundle\Conversion\PruebaAnnotationConverter;
use Tapir\AnnotationBundle\Entity\Prueba;

// Dependencias para la segunda prueba de Annotation personzalida
use Tapir\AnnotationBundle\Data\ClasePrueba2;
use Tapir\BaseBundle\Controller\AbmController;
use Doctrine\DBAL\DriverManager;

/**
 * @Route("prueba/")
 *
 * @author eriquelme
 *        
 */
class PruebaController extends AbmController
{

    /**
     * @Route("index/")
     * @Template("TapirAnnotationBundle:Default:index.html.twig")
     *
     * @param unknown $name            
     */
    public function indexAction($name = null)
    {
        // Primera prueba de una Annotation personalizada.
        $reader = new AnnotationReader();
        $converter = new PruebaAnnotationConverter($reader);
        $prueba = new Prueba();
        $PruebaAnnotation = $converter->convert($prueba);
        
        /*
         * Rutina que trae la Annotation personalizada y extrae los valores que contenga;
         * como por ejemplo, una breve descripción por tipo de entidad.
         */
        $procesador = $this->get('tapir_annotation.descripcion_procesador');
        $objeto = new ClasePrueba2();
        $procesador->fillObjectWithDefaultValues($objeto);
        
        $em = $this->getEm();
        
        // Para obtener todas las entidades que referencia a las tablas en la DB:
        $entities = array();
        $meta = $em->getMetadataFactory()->getAllMetadata();
        foreach ($meta as $m) {
            $entities[] = $m->getName();
        }
        
        $id = "1";
        $contador = 0;
        foreach ($entities as $entidad) {
            $resultado = $em->getClassMetadata($entidad)->getAssociationMappings();
            
            // Llamo a la rutina de búsqueda y el valor devuelto (el contador) se lo asigno a esta variable $contador.
            $contador += $this->rutinaBusqueda($resultado, $id);
        }
        
        $result2 = $em->getClassMetadata('Yacare\BaseBundle\Entity\Persona')->getFieldNames();
        foreach ($result2 as $res) {
            if ($res == 'Suprimido')
                //print_r('lo encontree')
                ;
        }
        //var_dump($result2);
        
        $contenido = $this->renderView('TapirAnnotationBundle:Default:email.html.twig');
        
        $transport = \Swift_SendmailTransport::newInstance('/usr/sbin/exim -t');
        $mailer = \Swift_Mailer::newInstance($transport);
        
        $mensaje = \Swift_Message::newInstance()
            ->setSubject('Envío de mail desde Yacaré')
            ->setFrom(array('reclamosriograndetdf@gmail.com' => 'Yacaré - Desarrollo'))
            ->setTo('rezequiel.tdf@gmail.com')
            ->setBody($contenido, 'text/html');
        $mailer->send($mensaje);
        //$this->get('mailer')->send($mensaje);
        
        return array(
            'name' => $name,
            'prueba' => $PruebaAnnotation,
            'objeto' => $objeto,
            'contador' => $contador
            
        );
    }

    public function construirDQL($id, $rutaRemitente, $variableRemitente)
    {
        $em = $this->getEm();
        $res = $em->createQueryBuilder()
            ->select('a, b')
            ->addselect('a.id')
            ->from($rutaRemitente, 'a')
            ->leftJoin('a.' . $variableRemitente, 'b')
            ->where('b.id = :condicion')
            ->setParameter('condicion', $id);
        
        $res = $res->getQuery()->getResult();
        
        return $res;
    }

    /**
     * Rutina de búsqueda de asociaciones, a partir de una entidad.
     *
     * Realiza una búsqueda a través de todas aquellas tablas en donde, la entidad,
     * estudiada, tenga relaciones de asociaciones. Identifica y devuelve un contador
     * con la cantidad de asociaciones encontradas, tanto del lado propietario, como
     * del lado inverso.
     * Por el momento sólo identifica con relaciones bidireccionales ManyToMany.
     *
     * @param array $result
     *            resultado de la consulta a la metadata de ORM.
     * @param mixed $conn
     *            conexión a la base de datos.
     * @param integer $id
     *            ID de la entidad a analizar.
     * @param string $tablaRemitente
     *            contiene la ruta a la clase de la entidad a estudiar.
     * @return integer $contador variable con la cantidad de relaciones encontradas para esa entidad.
     */
    protected function rutinaBusqueda($resultado, $id)
    {
        $contador = 0;
        $arrayAux = array();
        $ruta = 'Yacare\BaseBundle\Entity\Persona';
        if ($resultado != null) {
            // Preparo la rutina de recorrido e identificación de las partes que compondrán la sentencia SQL.
            // Recorro el array de la relación de la entidad a suprimir.
            foreach ($resultado as $valorRes) { // Recorro el primer nivel del array devuelto
                                                // con el mapeado de asociaciones.
                                                
                // Me aseguro que la entidad objetivo de $varloRes coincida con la ruta de la entidad a suprimir.
                if ($valorRes['targetEntity'] == $ruta) {
                    
                    switch ($valorRes['type']) {
                        // Reconozco que es una relación OneToOne.
                        case 1:
                            break;
                        
                        // Reconozco que es una relación ManyToOne. (No modifica el comportamiento si es uni o bidireccional)
                        case 2:
                            $arrayAux[] = $this->rutinaManyToOne($valorRes, $id);
                            break;
                        
                        // Reconozco que es una relación OneToMany. (Indistinto si se trata de bidireccionales o unidireccionales)
                        case 4:
                            $arrayAux[] = $this->rutinaOneToMany($valorRes, $id);
                            break;
                        
                        // Reconozco que es una relación ManyToMany. (bidireccionales)
                        case 8:
                            $arrayAux[] = $this->rutinaManyToMany($valorRes, $id);
                            break;
                        
                        default:
                            $contador = 'No posee relaciones';
                            break;
                    }
                }
            }
            if (count($arrayAux) == 1) {
                $contador += $arrayAux[0];
            } else {
                $contadorAux = 0;
                foreach ($arrayAux as $aux) {
                    if ($aux > $contadorAux) {
                        $contadorAux = $aux;
                    }
                }
                $contador += $contadorAux;
            }
            $arrayAux[] = array();
        }
        
        return $contador;
    }

    /**
     * Rutina destinada a la consulta de asociaciones para relaciones de ManyToOne.
     *
     * Rutina simple, en la que sólo detecta la entidad objetivo, en el array de asociaciones
     * y busca concordancia entre la ID de la entidad estudiada, con la entidad objetivo.
     *
     * @param array $valorRes            
     * @param string $tablaRemitente            
     * @param int $id            
     * @return int $contador
     */
    protected function rutinaManyToOne($valorRes, $id)
    {
        $variableRemitente = $valorRes['fieldName'];
        $rutaRemitente = $valorRes['sourceEntity'];
        $contador = count($this->construirDQL($id, $rutaRemitente, $variableRemitente));
        
        return $contador;
    }

    /**
     * Rutina encargada de manejar consulta en relaciones OneTomany.
     *
     * Rutina simple, extrae, la variable y la dirección de la entidad, que refieren al lado inverso de la relación.
     * Finaliza realizando una búsqueda en la entidad destinataria a partir del nombre de la variable extraída previamente, donde
     * ésta sea igual (=) a la $id de la entidad estudiada.
     *
     * @param array $valorRes            
     * @param int $id            
     * @return int
     */
    protected function rutinaOneToMany($valorRes, $id)
    {
        $variableRemitente = $valorRes['fieldName'];
        $rutaRemitente = $valorRes['sourceEntity'];
        $contador = count($this->construirDQL($id, $rutaRemitente, $variableRemitente));
        
        return $contador;
    }

    /**
     * Rutina que se encarga de realizar la consulta para la relación ManyToMany.
     *
     * Comienza a partir del segundo nivel del array de relaciones correspondiente a la entidad estudiada.
     * Continúa buscando e identificando distintas partes para diferenciar los lados PROPIETARIOS e INVERSOS.
     *
     * @param int $id            
     * @param string $tablaRemitente            
     * @param array $valorRes            
     * @return int $contador
     */
    protected function rutinaManyToMany($valorRes, $id)
    {
        $variableRemitente = $valorRes['fieldName'];
        $rutaRemitente = $valorRes['sourceEntity'];
        $contador = count($this->construirDQL($id, $rutaRemitente, $variableRemitente));
        
        return $contador;
    }
}

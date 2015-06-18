<?php
namespace Tapir\BaseBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Doctrine\DBAL\DriverManager;
use Zend\Cache\Pattern\ObjectCache;

/**
 * Trait que agrega la capacidad de eliminar entidades.
 *
 * La entidad controlada por el controlador debe ser Eliminable o Suprimible.
 *
 * @see \Tapir\BaseBundle\Entity\Eliminable
 * @see \Tapir\BaseBundle\Entity\Suprimible
 *
 * @author Ernesto Carrea <equistango@gmail.com>
 */
trait ConEliminar
{
    /**
     * Crea el formulario de eliminación.
     */
    protected function crearFormEliminar($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm();
    }

    /**
     * @Sensio\Bundle\FrameworkExtraBundle\Configuration\Route("eliminar/{id}")
     * @Sensio\Bundle\FrameworkExtraBundle\Configuration\Template("YacareBaseBundle:Default:eliminar.html.twig")
     */
    public function eliminarAction(Request $request, $id)
    {
        $deleteForm = $this->crearFormEliminar($id);
        
        $em = $this->getEm();
        $entity = $em->getRepository($this->VendorName . $this->BundleName . 'Bundle:' . $this->EntityName)->find($id);
        
        if (!$entity) {
            throw $this->createNotFoundException('No se puede encontrar la entidad.');
        }
        else {
        	//Para obtener todas las entidades que referencia a las tablas en la DB:
    		$entities = array();
    		$meta = $em->getMetadataFactory()->getAllMetadata();
    		foreach ($meta as $m) {
    			$entities[] = $m->getName();
    		}
    		
        	$contador = 0;
        	
        	//Recorro el array con todas las entidades de la aplicación.
        	foreach ($entities as $entidad) {
    				$resultado = $em->getClassMetadata($entidad)->getAssociationMappings();
    		
    				//Llamo a la rutina de búsqueda y el valor devuelto (el contador) se lo asigno a esta variable $contador.
    				$contador += $this->rutinaBusqueda ($resultado, $id);
    				if ($contador >= 5) break;
        	}
        }
        
        return $this->ArrastrarVariables($request, 
            array('entity' => $entity,'create' => $id ? false : true,'delete_form' => $deleteForm->createView()));
    }

    /**
     * @Sensio\Bundle\FrameworkExtraBundle\Configuration\Route("eliminar2/{id}")
     * @Sensio\Bundle\FrameworkExtraBundle\Configuration\Method("POST")
     * @Sensio\Bundle\FrameworkExtraBundle\Configuration\Template("YacareBaseBundle:Default:eliminar2.html.twig")
     */
    public function eliminar2Action(Request $request, $id)
    {
        $form = $this->crearFormEliminar($id);
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository($this->VendorName . $this->BundleName . 'Bundle:' . $this->EntityName)->find($id);
            
            if (in_array('Tapir\BaseBundle\Entity\Suprimible', class_uses($entity))) {
                // Es suprimible (soft-deletable), lo marco como borrado, pero no lo borro
                $entity->Suprimir();
                $em->persist($entity);
                $em->flush();
                $this->get('session')
                    ->getFlashBag()
                    ->add('info', 'Se suprimió el elemento "' . $entity . '".');
                return $this->afterEliminar($request, $entity, true);
            } else 
                if (in_array('Tapir\BaseBundle\Entity\Eliminable', class_uses($entity))) {
                    // Es eliminable... lo elimino de verdad
                    $em->remove($entity);
                    $em->flush();
                    $this->get('session')
                        ->getFlashBag()
                        ->add('info', 'Se eliminó el elemento "' . $entity . '".');
                    return $this->afterEliminar($request, $entity, true);
                } else {
                    // No es eliminable ni suprimible... no se puede borrar
                    $this->get('session')
                        ->getFlashBag()
                        ->add('info', 'No se puede eliminar el elemento "' . $entity . '".');
                }
        }
        
        return $this->afterEliminar($request, $entity);
    }

    /**
     * Este método se dispara después de eliminar una entidad.login
     *
     * @param bool $eliminado
     *            Indica si el elemento fue eliminado.
     */
    public function afterEliminar(Request $request, $entity, $eliminado = false)
    {
        return $this->redirect(
            $this->generateUrl($this->obtenerRutaBase('listar'), $this->ArrastrarVariables($request, null, false)));
    }
    
    /**
     * Método para construir una sentencia SELECT en formato DQL.
     * 
     * Busca, a partir de los parámetros dados, si existe una asociación
     * con el objeto a suprimir.
     * 
     * @param int $id ID de la entidad a suprimir.
     * @param string $rutaRemitente ruta a la entidad que referencia al objeto a suprimir.
     * @param string $variableRemitente variable que referencia al objeto de la entidad a suprimir.
     * @return array $res resultado de la consulta.
     */
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
    	 
    	$res = $res->getQuery()->setMaxResults(5)->getResult();
    	 
    	return $res;
    }
    
    /**
     * Rutina de búsqueda de asociaciones, a partir del objeto de una entidad.
     *
     * Realiza una búsqueda a través de todas aquellas tablas en donde, la entidad del
     * objeto estudiado, tenga relaciones de asociaciones. Identifica y devuelve un 
     * contador con la cantidad de asociaciones encontradas.
     *
     * @param array $resultado de la consulta a la metadata de ORM.
     * @param integer $id de la entidad a analizar.
     * 
     * @return integer $contador variable con la cantidad de relaciones encontradas para esa entidad.
     */
    protected function rutinaBusqueda($resultado, $id)
    {
    	$contador = 0;
    	$arrayAux = array();
    	
    	if ($resultado != null) {
    		
    		//Recorro el array de la relación de la entidad a suprimir.
    		foreach ($resultado as $valorRes) {//Recorro el primer nivel del array devuelto
    			//con el mapeado de asociaciones.
    			
    			//Me aseguro que la entidad objetivo de $varloRes coincida con la ruta de la entidad del objeto a suprimir.
    			if ($valorRes['targetEntity'] == trim($this->CompleteEntityName , '\\') && $valorRes['isOwningSide']) {
    				
    				switch ($valorRes['type']) {
    					//Reconozco que es una relación OneToOne.
    					case 1:
    						break;
    					 
    					//Reconozco que es una relación ManyToOne.
    					case 2:
    						$arrayAux[] = $this->rutinaManyToOne($valorRes, $id);
    						break;
    
    					//Reconozco que es una relación OneToMany.
    					case 4:
    						$arrayAux[] = $this->rutinaOneToMany($valorRes, $id);
    						break;
    
    					//Reconozco que es una relación ManyToMany.
    					case 8:
    						$arrayAux[] = $this->rutinaManyToMany($valorRes, $id);
    						break;
    
    					default:
    						$contador = 'No posee relaciones';
    						break;
    				}
    				if (count($arrayAux) == 1 && $arrayAux[0] >= 5) break;
    				
    				else foreach ($arrayAux as $aux) if ($aux >= 5) break;
    			}
    		}
    		
    		/* 
    		 * Evalúo si una entidad referencia, a la entidad del objeto estudiado, en más de una (1)
    		 * variable, es decir, posee 2 o más variables que referencian (dentro de una entidad) a la entidad
    		 * del objeto a suprimir.
    		 */
    		if (count($arrayAux) == 1) $contador += $arrayAux[0];
    		
    		else {
    			$contadorAux = 0;
    			foreach ($arrayAux as $aux) if ($aux > $contadorAux) $contadorAux = $aux;
    			$contador += $contadorAux;
    		}
    		$arrayAux[] = array();
    	}
    	 
    	return $contador;
    }
    /**
     * Rutina destinada a la consulta de asociaciones para relaciones de ManyToOne.
     *
     * Rutina simple, en la que sólo obtiene la ruta de la entidad remitente (que referencia a la entidad a suprimir), 
     * en el array de asociaciones y busca concordancia entre la ID de la entidad estudiada, con la entidad remitente.
     *
     * @param array $valorRes
     * @param int $id
     * 
     * @return int $contador
     */
    protected function rutinaManyToOne($valorRes, $id)
    {
    	$em = $this->getEm();
    	$variableRemitente = $valorRes['fieldName'];
    	$rutaRemitente = $valorRes['sourceEntity'];
    	$contador = count($em->getRepository($rutaRemitente)->findBy(array($variableRemitente => $id), array('id' => 'ASC'), 5));
    	 
    	return $contador;
    }
    
    /**
     * Rutina encargada de manejar consulta en relaciones OneTomany.
     *
     * @param array $valorRes
     * @param int $id
     * 
     * @return int $contador
     */
    protected function rutinaOneToMany($valorRes, $id)
    {
    	$em = $this->getEm();
    	$variableRemitente = $valorRes['fieldName'];
    	$rutaRemitente = $valorRes['sourceEntity'];
    	$contador = count($em->getRepository($rutaRemitente)->findBy(array($variableRemitente => $id), array('id' => 'ASC'), 5));
    	 
    	return $contador;
    }
    
    /**
     * Rutina que se encarga de realizar la consulta para la relación ManyToMany.
     *
     * @param int $id
     * @param array $valorRes
     * 
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
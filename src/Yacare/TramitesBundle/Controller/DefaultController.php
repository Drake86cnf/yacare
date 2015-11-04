<?php
namespace Yacare\TramitesBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Controlador de inicio
 * 
 * @author Ezequiel Riquelme <rezequiel.tdf@gmail.com>
 */
class DefaultController extends \Tapir\BaseBundle\Controller\DefaultController
{
    /**
     * Controlador de inicio.
     * 
     * @see \Tapir\BaseBundle\Controller\DefaultController::inicioAction() DefaultController::inicioAction()
     * 
     * @Route("inicio/")
     * @Template()
     */
    public function inicioAction(\Symfony\Component\HttpFoundation\Request $request)
    {
        $res = parent::inicioAction($request);
        
        $entitiesRecientes = array();
        $em = $this->getEm();
        $entities = $em->getRepository('YacareTramitesBundle:Requisito')->findBy(array('Tipo' => 'ext'));
        
        foreach ($entities as $entity) {
            $ultimaActualizacion = $entity->getUpdatedAt()->diff(new \DateTime());
            $limiteCantidad = 0;
            if ($ultimaActualizacion->days <= 10 && $limiteCantidad <= 5) {
                $entitiesRecientes[] = $entity;
                $limiteCantidad++;
            }
        }
        $res['entities'] = $entitiesRecientes;
        $res['entitiesCantidad'] = count($entities);
        
        return $res;
    }
}

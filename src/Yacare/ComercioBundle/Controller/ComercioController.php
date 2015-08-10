<?php
namespace Yacare\ComercioBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Yacare\ComercioBundle\Entity\Actividad;

/**
 * @Route("comercio/")
 */
class ComercioController extends \Tapir\BaseBundle\Controller\AbmController
{
    use \Tapir\BaseBundle\Controller\ConBuscar;

    /**
     * @Route("altamanual/")
     * @Template()
     */
    function altamanualAction(Request $request)
    {
        return $this->ArrastrarVariables($request);
    }

    /**
     * Interviene las actividades antes de persistirlas en un comercio.
     * 
     * @see \Tapir\BaseBundle\Controller\AbmController::guardarActionPrePersist()
     */
    public function guardarActionPrePersist($entity, $flag)
    {
        $flag = false;
        
        if ($entity->getActividad6() && ! $entity->getActividad5()) {
            $entity->setActividad5($entity->getActividad6());
            $entity->setActividad6(null);
            $flag = true;
        }
        
        if ($entity->getActividad5() && ! $entity->getActividad4()) {
            $entity->setActividad4($entity->getActividad5());
            $entity->setActividad5(null);
            $flag = true;
        }
        
        if ($entity->getActividad4() && ! $entity->getActividad3()) {
            $entity->setActividad3($entity->getActividad4());
            $entity->setActividad4(null);
            $flag = true;
        }
        
        if ($entity->getActividad3() && ! $entity->getActividad2()) {
            $entity->setActividad2($entity->getActividad3());
            $entity->setActividad3(null);
            $flag = true;
        }
        
        if ($flag) {
            return $this->guardarActionPrePersist($entity, $flag);
        } else {
            return array();
        }
    }
}
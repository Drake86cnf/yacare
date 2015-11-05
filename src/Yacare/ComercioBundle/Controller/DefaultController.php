<?php
namespace Yacare\ComercioBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Controlador de inicio.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class DefaultController extends \Tapir\BaseBundle\Controller\DefaultController
{
    /**
     * @Route("inicio/")
     * @Template
     */
    public function inicioAction(Request $request)
    {
        $em = $this->getEm();
        
        $Tramites = $em->createQuery(
            'SELECT r FROM Yacare\ComercioBundle\Entity\TramiteHabilitacionComercial r WHERE r.Estado<90')->getResult();
        $Comercios = $em->createQuery(
            'SELECT r FROM Yacare\ComercioBundle\Entity\Comercio r WHERE r.Estado=1')->getResult();
        $Locales = $em->createQuery(
            'SELECT r FROM Yacare\ComercioBundle\Entity\Local r')->getResult();
        
        return $this->ArrastrarVariables($request, array('tramites' => $Tramites, 'comercios'=>$Comercios, 'locales'=>$Locales));
    }
}

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
        
        $res = $this->ConstruirResultado(new \Yacare\ComercioBundle\Helper\Resultados\ResultadoInicioAction($this), 
            $request);
        
        $res->Tramites = $em->createQuery(
            'SELECT r FROM Yacare\ComercioBundle\Entity\TramiteHabilitacionComercial r WHERE r.Estado<90')->getResult();
        $res->Comercios = $em->createQuery('SELECT r FROM Yacare\ComercioBundle\Entity\Comercio r WHERE r.Estado=1')->getResult();
        $res->Locales = $em->createQuery('SELECT r FROM Yacare\ComercioBundle\Entity\Local r')->getResult();
        
        return array('res' => $res);
    }
}

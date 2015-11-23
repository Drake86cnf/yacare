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
        
        $res->Contadores['Local'] = $em->createQuery('SELECT COUNT(r.id) FROM Yacare\ComercioBundle\Entity\Local r WHERE r.Suprimido=0')->getSingleScalarResult();
        $res->Contadores['Comercio'] = $em->createQuery('SELECT COUNT(r.id) FROM Yacare\ComercioBundle\Entity\Comercio r WHERE r.Suprimido=0')->getSingleScalarResult();
        $res->Contadores['ActaComercio'] = $em->createQuery('SELECT COUNT(r.id) FROM Yacare\ComercioBundle\Entity\ActaComercio r')->getSingleScalarResult();
        
        return array('res' => $res);
    }
}

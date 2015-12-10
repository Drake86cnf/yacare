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
    use \Tapir\AyudaBundle\Controller\ConAyuda;
    
    /**
     * @Route("inicio/")
     * @Template
     */
    public function inicioAction(Request $request)
    {
        $res = $this->ConstruirResultado(new \Yacare\ComercioBundle\Helper\Resultados\ResultadoInicioAction($this),
            $request);
        
        $this->ObtenerContadoresYRecientes($res);
        
        return array('res' => $res);
    }
    
    
    /**
     * @Route("miniinicio/")
     * @Template
     */
    public function miniinicioAction(Request $request)
    {
        $res = $this->ConstruirResultado(new \Yacare\ComercioBundle\Helper\Resultados\ResultadoInicioAction($this),
            $request);
        
        $this->ObtenerContadoresYRecientes($res);
    
        return array('res' => $res);
    }
    
    public function ObtenerContadoresYRecientes($resultado) {
        $em = $this->getEm();
        
        $resultado->Contadores['Local'] = $em->createQuery('SELECT COUNT(r.id) FROM Yacare\ComercioBundle\Entity\Local r WHERE r.Suprimido=0')->getSingleScalarResult();
        $resultado->Contadores['Comercio'] = $em->createQuery('SELECT COUNT(r.id) FROM Yacare\ComercioBundle\Entity\Comercio r WHERE r.Suprimido=0')->getSingleScalarResult();
        $resultado->Contadores['ActaComercio'] = $em->createQuery('SELECT COUNT(r.id) FROM Yacare\ComercioBundle\Entity\ActaComercio r')->getSingleScalarResult();
        
        $resultado->Recientes['Comercio'] = $em->createQuery('SELECT r FROM Yacare\ComercioBundle\Entity\Comercio r
            WHERE r.Suprimido=0 ORDER BY r.RequiereAtencion DESC, r.updatedAt DESC')->setMaxResults(10)->getResult();
        $resultado->Recientes['Local'] = $em->createQuery('SELECT r FROM Yacare\ComercioBundle\Entity\Local r
            WHERE r.Suprimido=0 ORDER BY r.updatedAt DESC')->setMaxResults(10)->getResult();
        
        return $resultado;
    }
}

<?php
namespace Yacare\FlotaBundle\Controller;

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
        
        $resultado->Recientes['Vehiculo'] = $em->createQuery('SELECT r FROM Yacare\FlotaBundle\Entity\Vehiculo r WHERE r.Suprimido=0 ORDER BY r.updatedAt DESC')->setMaxResults(10)->getResult();
        
        return $resultado;
    }
}

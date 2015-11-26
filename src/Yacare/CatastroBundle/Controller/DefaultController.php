<?php
namespace Yacare\CatastroBundle\Controller;

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
        
        $resultado->Contadores['Calle'] = $em->createQuery('SELECT COUNT(r.id) FROM Yacare\CatastroBundle\Entity\Calle r')->getSingleScalarResult();
        $resultado->Contadores['Partida'] = $em->createQuery('SELECT COUNT(r.id) FROM Yacare\CatastroBundle\Entity\Partida r')->getSingleScalarResult();
        $resultado->Contadores['Zona'] = $em->createQuery('SELECT COUNT(r.id) FROM Yacare\CatastroBundle\Entity\Zona r')->getSingleScalarResult();
        
        return $resultado;
    }
}

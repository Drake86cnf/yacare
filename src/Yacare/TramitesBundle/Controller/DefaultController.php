<?php
namespace Yacare\TramitesBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
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
    
    public function ObtenerContadoresYRecientes($resultado)
    {
        $em = $this->getEm();
    
        $resultado->Recientes['Requisito'] = $em->createQuery("SELECT r FROM Yacare\TramitesBundle\Entity\Requisito r WHERE r.Tipo IN ('cont', 'int', 'ext') ORDER BY r.updatedAt DESC")
            ->setMaxResults(10)->getResult();
        $resultado->Recientes['TramiteTipo'] = $em->createQuery("SELECT r FROM Yacare\TramitesBundle\Entity\TramiteTipo r ORDER BY r.updatedAt DESC")
            ->setMaxResults(10)->getResult();
        $resultado->Recientes['ComprobanteTipo'] = $em->createQuery("SELECT r FROM Yacare\TramitesBundle\Entity\ComprobanteTipo r ORDER BY r.updatedAt DESC")
            ->setMaxResults(10)->getResult();

        return $resultado;
    }
   
}

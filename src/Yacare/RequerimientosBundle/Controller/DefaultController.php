<?php
namespace Yacare\RequerimientosBundle\Controller;

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
        
        $UsuarioConectado = $this->get('security.token_storage')->getToken()->getUser();
        if($this->get('security.authorization_checker')->isGranted('ROLE_REQUERIMIENTOS_ADMINISTRADOR')) {
            $resultado->Recientes['RequerimientosSinEncargado'] = $em->createQuery('SELECT r FROM Yacare\RequerimientosBundle\Entity\Requerimiento r WHERE r.Encargado IS NULL AND r.Estado < 50')
                ->setMaxResults(10)
                ->getResult();
        }
        
        //$resultado->Contadores['Requerimiento'] = $em->createQuery('SELECT COUNT(r.id) FROM Yacare\RequerimientosBundle\Entity\Requerimiento r WHERE r.Estado<50')->getSingleScalarResult();
        
        $resultado->Recientes['RequerimientosUsuario'] = $em->createQuery('SELECT r FROM Yacare\RequerimientosBundle\Entity\Requerimiento r WHERE r.Encargado = :encargado AND r.Estado < 50')
            ->setParameter('encargado', $UsuarioConectado)
            ->setMaxResults(10)
            ->getResult();
        $resultado->Recientes['RequerimientosEncargado'] = $em->createQuery('SELECT r FROM Yacare\RequerimientosBundle\Entity\Requerimiento r WHERE r.Usuario = :usuario AND r.Estado < 50')
            ->setParameter('usuario', $UsuarioConectado)
            ->setMaxResults(10)
            ->getResult();
        
        return $resultado;
    }
}

<?php
namespace Yacare\ObrasParticularesBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Controlador de inicio.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 * 
 * @Security("has_role('ROLE_IDDQD') or has_role('ROLE_OBRAS_PARTICULARES') or has_role('ROLE_OBRAS_PARTICULARES_ADMINISTRADOR')")
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

    public function ObtenerContadoresYRecientes($resultado)
    {
        $em = $this->getEm();
        
        $resultado->Contadores['ActaObra'] = $em->createQuery(
            'SELECT COUNT(r.id) FROM Yacare\ObrasParticularesBundle\Entity\ActaObra r')->getSingleScalarResult();
        $resultado->Contadores['Matriculado'] = $em->createQuery(
            'SELECT COUNT(r.id) FROM Yacare\ObrasParticularesBundle\Entity\Matriculado r WHERE r.Suprimido=0')->getSingleScalarResult();
        $resultado->Contadores['EmpresaConstructora'] = $em->createQuery(
            'SELECT COUNT(r.id) FROM Yacare\ObrasParticularesBundle\Entity\EmpresaConstructora r WHERE r.Suprimido=0')->getSingleScalarResult();
        $resultado->Contadores['TramiteCat'] = $em->createQuery(
            'SELECT COUNT(r.id) FROM Yacare\ObrasParticularesBundle\Entity\TramiteCat r')->getSingleScalarResult();
        $resultado->Contadores['TramitePlanos'] = $em->createQuery(
            'SELECT COUNT(r.id) FROM Yacare\ObrasParticularesBundle\Entity\TramitePlanos r')->getSingleScalarResult();
        
        $resultado->Recientes['TramiteCat'] = $em->createQuery(
            'SELECT r FROM Yacare\ObrasParticularesBundle\Entity\TramiteCat r ORDER BY r.updatedAt DESC')->setMaxResults(
            10)->getResult();
        $resultado->Recientes['ActaObra'] = $em->createQuery(
            'SELECT r FROM Yacare\ObrasParticularesBundle\Entity\ActaObra r ORDER BY r.updatedAt DESC')->setMaxResults(
            10)->getResult();
        $resultado->Recientes['Matriculado'] = $em->createQuery(
            'SELECT r FROM Yacare\ObrasParticularesBundle\Entity\Matriculado r WHERE r.Suprimido=0 ORDER BY r.updatedAt DESC')->setMaxResults(
            10)->getResult();
        $resultado->Recientes['EmpresaConstructora'] = $em->createQuery(
            'SELECT r FROM Yacare\ObrasParticularesBundle\Entity\EmpresaConstructora r WHERE r.Suprimido=0 ORDER BY r.updatedAt DESC')->setMaxResults(
            10)->getResult();
        
        return $resultado;
    }
}

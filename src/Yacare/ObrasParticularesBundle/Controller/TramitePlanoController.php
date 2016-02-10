<?php
namespace Yacare\ObrasParticularesBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


/**
 * Controlador de movimientos de previas.
 * 
 * @author Ezequiel Riquelme <rezquiel.tdf@gmail.com>
 * 
 * @Route("tramiteplano/")
 */
class TramitePlanoController extends \Yacare\TramitesBundle\Controller\TramiteController
{
    //use \Yacare\AdministracionBundle\Controller\ConSeguimiento;

    /**
     * @Route("adjuntos/listar/")
     * @Security("has_role('ROLE_IDDQD') or has_role('ROLE_OBRAS_PARTICULARES_ADMINISTRADOR')")
     * @Template("YacareObrasParticularesBundle:ActaObra:adjuntos_listar.html.twig")
     */
    public function adjuntoslistarAction(Request $request)
    {
        return parent::adjuntoslistarAction($request);
    }

    /**
     * Editar un tramite de planos.
     *
     * @see \Tapir\AbmBundle\Controller\AbmController::editarAction() AbmController::editarAction()
     *
     * @Route("editar/")
     * @Route("crear/")
     * @Security("has_role('ROLE_IDDQD') or has_role('ROLE_OBRAS_PARTICULARES_ADMINISTRADOR')")
     * @Template()
     */
    public function editarAction(Request $request)
    {
        return parent::editarAction($request);
    }

    /**
     * El inicio de obra de un tramite plano.
     * 
     * @Route("iniciodeobra/")
     * @Security("has_role('ROLE_IDDQD') or has_role('ROLE_OBRAS_PARTICULARES_ADMINISTRADOR')")
     * @Template()
     */
    public function iniciodeobraAction(Request $request)
    {
        $em = $this->getEm();
        $id = $this->ObtenerVariable($request, 'id');
        
        if ($id) {
            $entity = $this->ObtenerEntidadPorId($id);
            $entity->setInicioDeObra(new \DateTime('now'));
            $formEditar = $this->createFormBuilder($entity);
        }
        $em->flush();
        $res = $this->ConstruirResultado(new \Tapir\AbmBundle\Helper\Resultados\ResultadoVerAction($this), $request);
        $res->Form = $formEditar;
        $res->Entidad = $entity;
        
        return array('res' => $res);
    }
}

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
 * @Security("has_role('ROLE_IDDQD') or has_role('ROLE_OBRAS_PARTICULARES_ADMINISTRADOR') or has_role('ROLE_OBRAS_PARTICULARES_MESA_DE_ENTRADA')")
 */
class TramitePlanoController extends \Yacare\TramitesBundle\Controller\TramiteController
{
    // use \Yacare\AdministracionBundle\Controller\ConSeguimiento;
    
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
            $Entidad = $this->ObtenerEntidadPorId($id);
            $Entidad->setInicioDeObra(new \DateTime('now'));
            $formEditar = $this->createFormBuilder($Entidad);
        }
        $em->flush();
        $res = $this->ConstruirResultado(new \Tapir\AbmBundle\Helper\Resultados\ResultadoVerAction($this), $request);
        $res->Form = $formEditar;
        $res->Entidad = $Entidad;
        
        return array('res' => $res);
    }

    /**
     * Caratula la previa de acuerod al Siaf.
     *
     * @Route("caratularprevia/")
     * @Template()
     */
    public function caratularpreviaAction(Request $request)
    {
        $em = $this->getEm();
        $id = $this->ObtenerVariable($request, 'id');
        
        if ($id) {
            $Entidad = $this->ObtenerEntidadPorId($id);
        }
        
        if (! $Entidad) {
            throw $this->createNotFoundException('No se puede encontrar la entidad.');
        }
        
        $FormEditarBuilder = $this->createFormBuilder($Entidad);
        
        $FormEditarBuilder
            ->add('ExpedienteNumero', 'Yacare\AdministracionBundle\Form\Type\ExpedienteType', array(
                'label' => 'Nº de expediente'))
            ->add('FechaAprobadaPrevia', 'Tapir\BaseBundle\Form\Type\FechaPasadoPresenteType', array(
                'label' => 'Fecha de aprobado'));
        
        $FormEditar = $FormEditarBuilder->getForm();
        $FormEditar->handleRequest($request);
        
        if ($FormEditar->isValid()) {
            $em->persist($Entidad);
            $em->flush();
            
            return $this->guardarActionAfterSuccess($request, $Entidad);
        } else {
            $Errores = $FormEditar->getErrors(true, true);
        }
        
        if ($Errores) {
            foreach ($Errores as $error) {
                $this->get('session')->getFlashBag()->add('danger', $error->getMessage());
            }
        } else {
            $Errores = null;
        }
        
        $res = $this->ConstruirResultado(new \Tapir\AbmBundle\Helper\Resultados\ResultadoEditarGuardarAction($this), 
            $request);
        $res->Entidad = $Entidad;
        $res->AccionGuardar = 'caratularprevia';
        $res->FormularioEditar = $FormEditar->createView();
        $res->Errores = $Errores;
        
        return array('res' => $res);
    }

    /**
     * @Route("listar/")
     * @Template()
     */
    public function listarAction(Request $request)
    {
        return parent::listarAction($request);
    }

    /**
     * @Route("ver/")
     * @Template()
     */
    public function verAction(Request $request)
    {
        return parent::verAction($request);
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
     * @Route("adjuntos/listar/")
     * @Security("has_role('ROLE_IDDQD') or has_role('ROLE_OBRAS_PARTICULARES_ADMINISTRADOR')")
     * @Template("YacareObrasParticularesBundle:ActaObra:adjuntos_listar.html.twig")
     */
    public function adjuntoslistarAction(Request $request)
    {
        return parent::adjuntoslistarAction($request);
    }
}

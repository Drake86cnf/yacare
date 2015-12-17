<?php
namespace Yacare\ObrasParticularesBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Controlador de actas de obra.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 * @author Ezequiel Riquelme <rezequiel.tdf@gmail.com>
 * 
 * @Route("actaobra/")
 * @Security("has_role('ROLE_IDDQD') or has_role('ROLE_OBRAS_PARTICULARES') or has_role('ROLE_OBRAS_PARTICULARES_ADMINISTRADOR') or has_role('ROLE_OBRAS_PARTICULARES_INSPECTOR')")
 */
class ActaObraController extends \Tapir\AbmBundle\Controller\AbmController
{
    use \Tapir\AbmBundle\Controller\ConVer;

    function IniciarVariables()
    {
        parent::IniciarVariables();
        
        // TODO: Implementar que filtre por fecha
        $this->BuscarPor = 'Numero, SubTipo, Fecha';
        $this->OrderBy = 'r.Numero DESC';
    }

    /**
     * @Route("listar/")
     * @Template()
     */
    public function listarAction(Request $request)
    {
        $filtro_buscar = $this->ObtenerVariable($request, 'filtro_buscar');
        
        if ($filtro_buscar) {
            $this->Joins[] = " LEFT JOIN r.Partida pa";
            $this->Joins[] = " LEFT JOIN pa.Titular t";
            $this->Joins[] = 'JOIN r.FuncionarioPrincipal fp';
            
            $this->BuscarPor .= ', fp.NombreVisible, t.NombreVisible, t.DocumentoNumero, t.Cuilt, pa.Nombre';
        }
        $res = parent::listarAction($request);
        
        return $res;
    }

    /**
     * Editar un acta.
     * 
     * @see \Tapir\AbmBundle\Controller\AbmController::editarAction() AbmController::editarAction()
     * 
     * @Route("editar/")
     * @Route("crear/")
     * @Security("has_role('ROLE_IDDQD') or has_role('ROLE_OBRAS_PARTICULARES_ADMINISTRADOR') or has_role('ROLE_OBRAS_PARTICULARES_INSPECTOR')")
     * @Template()
     */
    public function editarAction(Request $request)
    {
        if (! $this->isGranted('ROLE_IDDQD')) {
            if ($this->ObtenerVariable($request, 'id') && ($this->isGranted('ROLE_OBRAS_PARTICULARES_INSPECTOR') &&
                 ! $this->isGranted('ROLE_OBRAS_PARTICULARES_ADMINISTRADOR'))) {
                return $this->redirect($this->generateUrl('yacare_base_default_accesodenegado'));
            } else {
                return parent::editarAction($request);
            }
        } else {
            return parent::editarAction($request);
        }
    }

    /**
     * Guardar un acta.
     *
     * @see \Tapir\AbmBundle\Controller\AbmController::guardarAction() AbmController::guardarAction()
     *
     * @Route("guardar/")
     * @Sensio\Bundle\FrameworkExtraBundle\Configuration\Method("POST")
     * @Security("has_role('ROLE_IDDQD') or has_role('ROLE_OBRAS_PARTICULARES_ADMINISTRADOR') or has_role('ROLE_OBRAS_PARTICULARES_INSPECTOR')")
     * @Template()
     */
    public function guardarAction(Request $request)
    {
        return parent::guardarAction($request);
    }

    /**
     * Emite el descargo de un acta en particular.
     * 
     * @Route("emitirdescargo/")
     * @Security("has_role('ROLE_IDDQD') or has_role('ROLE_OBRAS_PARTICULARES_ADMINISTRADOR')")
     * @Template()
     */
    public function emitirdescargoAction(Request $request)
    {
        $id = $this->ObtenerVariable($request, 'id');
        $em = $this->getEm();
        
        if ($id) {
            $entity = $this->ObtenerEntidadPorId($id);
        }
        
        if (! $entity) {
            throw $this->createNotFoundException('No se puede encontrar la entidad.');
        }
        
        $FormEditarBuilder = $this->createFormBuilder($entity);
        
        $FormEditarBuilder
            ->add('Plazo', 'Yacare\ObrasParticularesBundle\Form\Type\PlazoType', array(
                'label' => 'Plazo', 
                'attr' => array('class' => 'tapir-input-160'), 
                'required' => true))
            ->add('Profesional', 'Tapir\FormBundle\Form\Type\EntityIdType', array(
                'label' => 'Profesional', 
                'class' => 'Yacare\ObrasParticularesBundle\Entity\Matriculado', 
                'required' => false))
            ->add('DescargoDetalle', null, array('label' => 'Detalle'));
        
        $FormEditar = $FormEditarBuilder->getForm();
        $FormEditar->handleRequest($request);
        
        if ($FormEditar->isValid()) {
            $entity->setFechaDescargo(new \DateTime());
            
            $em->persist($entity);
            $em->flush();
            
            return $this->guardarActionAfterSuccess($request, $entity);
        } else {
            $children = $FormEditar->all();
            
            foreach ($children as $child) {
                $child->getErrorsAsString();
            }
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
        $res->Entidad = $entity;
        $res->AccionGuardar = 'emitirdescargo';
        $res->FormularioEditar = $FormEditar->createView();
        $res->Errores = $Errores;
        
        return array('res' => $res);
    }

    /**
     * Ver el descargo de un acta.
     *
     * @see verAction() verAction()
     *
     * @Route("verdescargo/")
     * @Template()
     */
    public function verdescargoAction(Request $request)
    {
        return $this->verAction($request);
    }

    /**
     * @Route("adjuntos/listar/")
     * @Security("has_role('ROLE_IDDQD') or has_role('ROLE_OBRAS_PARTICULARES_ADMINISTRADOR') or has_role('ROLE_OBRAS_PARTICULARES_INSPECTOR')")
     * @Template("YacareObrasParticularesBundle:ActaObra:adjuntos_listar.html.twig")
     */
    public function adjuntoslistarAction(Request $request)
    {
        $em = $this->getEm();
        $id = $this->ObtenerVariable($request, 'id');
        
        $ActaObra = $this->ObtenerEntidadPorId($id);
        
        $AdjuntoNuevo = new \Yacare\BaseBundle\Entity\Adjunto();
        $AdjuntoNuevo->setEntidadTipo(get_class($ActaObra));
        $AdjuntoNuevo->setEntidadId($ActaObra->getId());
        
        $FormSubirBuilder = $this->createFormBuilder($ActaObra);
        $FormSubirBuilder->add('Nombre', 'file', 
            array('label' => 'Adjuntar archivo', 'data_class' => null, 'attr' => array('multiple' => 'multiple')));
        
        $FormSubir = $FormSubirBuilder->getForm();
        
        $Adjuntos = $em->getRepository('YacareBaseBundle:Adjunto')->findBy(
            array('EntidadTipo' => get_class($ActaObra), 'EntidadId' => $ActaObra->getId(), 'Suprimido' => 0));
        $em->flush();
        
        $res = $this->ConstruirResultado(new \Yacare\BaseBundle\Helper\Resultados\ResultadoAdjuntosListarAction($this), 
            $request);
        $res->Entidad = $ActaObra;
        $res->EntidadTipo = get_class($ActaObra);
        $res->EntidadId = $ActaObra->getId();
        $res->Entidades = $Adjuntos;
        $res->FormularioSubir = $FormSubir->createView();
        
        return array('res' => $res);
    }
}

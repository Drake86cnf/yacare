<?php
namespace Yacare\ObrasParticularesBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Controlador de actas de obra.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 * @author Ezequiel Riquelme <rezequiel.tdf@gmail.com>
 * 
 * @Route("actaobra/")
 * @Template()
 */
class ActaObraController extends \Tapir\AbmBundle\Controller\AbmController
{
    use \Tapir\AbmBundle\Controller\ConVer {
        \Tapir\AbmBundle\Controller\ConVer::verAction as parent_verAction;
    }
    
    function IniciarVariables()
    {
        parent::IniciarVariables();
        
        // TODO: Implementar que filtre por fecha
        $this->BuscarPor = 'Numero, SubTipo, Fecha, fp.NombreVisible';
        
        if (in_array('r.FuncionarioPrincipal fp', $this->Joins) == false) {
            $this->Joins[] = 'JOIN r.FuncionarioPrincipal fp';
        }
        
        $this->OrderBy = 'r.Numero DESC';
    }

    /**
     * Emite el descargo de un acta en particular.
     * 
     * @Route("emitirdescargo/")
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
                'required' => true))
            ->add('Profesional', 'Tapir\FormBundle\Form\Type\EntityIdType', array(
                'label' => 'Profesional', 
                'class' => 'Yacare\ObrasParticularesBundle\Entity\Matriculado', 
                'required' => false))
            ->add('DescargoDetalle', null, array('label' => 'Detalles adicionales'));
        
        $FormEditar = $FormEditarBuilder->getForm();
        $FormEditar->handleRequest($request);
        
        if ($FormEditar->isValid()) {
            $entity->setFechaDescargo(new \DateTime());
            
            $em->persist($entity);
            $em->flush();
            
            return $this->redirect($this->generateUrl($this->obtenerRutaBase('verdescargo'), 
                $this->ArrastrarVariables($request, array('id' => $id), false)));
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
        return $this->parent_verAction($request);
    }

    /**
     * @Route("adjuntos/listar/")
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

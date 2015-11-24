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
    function IniciarVariables()
    {
        parent::IniciarVariables();
        
        // TODO: Implementar que filtre por fecha
        $this->BuscarPor = 'Numero, SubTipo, Fecha, fp.NombreVisible';
        
        if (in_array('r.FuncionarioPrincipal fp', $this->Joins) == false) {
            $this->Joins[] = 'JOIN r.FuncionarioPrincipal fp';
        }
        
        $this->OrderBy = 'r.Fecha DESC';
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
            
            if ($entity->getPlazo() || $entity->getFechaDescargo()) {
                return $this->redirect($this->generateUrl($this->obtenerRutaBase('verdescargo'),
                    $this->ArrastrarVariables($request, array('id' => $id), false)));
            }
        }
        
        if (! $entity) {
            throw $this->createNotFoundException('No se puede encontrar la entidad.');
        }
        
        $FormEditarBuilder = $this->createFormBuilder($entity);
        
        $FormEditarBuilder
            ->add('Plazo', 'choice', array(
                'choices' => array(
                    '1' => '1 día',
                    '5' => '5 días',
                    '10' => '10 días',
                    '30' => '30 días',
                    '60' => '60 días',
                    '90' => '90 días'
                ),
                'label' => 'Plazo',
                'required' => true));
        
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
        return parent::verAction($request);
    }
}

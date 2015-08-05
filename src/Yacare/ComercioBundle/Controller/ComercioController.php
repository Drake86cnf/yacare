<?php
namespace Yacare\ComercioBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("comercio/")
 */
class ComercioController extends \Tapir\BaseBundle\Controller\AbmController
{
    use \Tapir\BaseBundle\Controller\ConBuscar;

    /**
     * @Route("altamanual/")
     * @Template()
     */
    function altamanualAction(Request $request)
    {
        return $this->ArrastrarVariables($request);
    }

    /**
     * @Route("editar/{id}")
     * @Route("crear/")
     * @Template()
     */
    public function editarAction(Request $request, $id = null)
    {
        if ($id) {
            $entity = $this->obtenerEntidadPorId($id);
        } else {
            $entity = $this->crearNuevaEntidad($request);
        }
        
        if (! $entity) {
            throw $this->createNotFoundException('No se puede encontrar la entidad.');
        }
        
        // $typeName = $this->obtenerFormType();
        $editForm = $this->createForm(new \Yacare\ComercioBundle\Form\ActividadComercioType(), $entity);
        if ($id) {
            $deleteForm = $this->crearFormEliminar($id);
        } else {
            $deleteForm = null;
        }
        
        return $this->ArrastrarVariables($request, 
                array('entity' => $entity, 'create' => $id ? false : true, 'errors' => '', 
                    'edit_form' => $editForm->createView(), 
                    'delete_form' => $deleteForm ? $deleteForm->createView() : null));
    }
}
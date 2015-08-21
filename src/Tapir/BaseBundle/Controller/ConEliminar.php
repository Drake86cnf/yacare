<?php
namespace Tapir\BaseBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Doctrine\DBAL\DriverManager;
use Zend\Cache\Pattern\ObjectCache;

/**
 * Trait que agrega la capacidad de eliminar entidades.
 *
 * La entidad controlada por el controlador debe ser Eliminable o Suprimible.
 *
 * @see \Tapir\BaseBundle\Entity\Eliminable
 * @see \Tapir\BaseBundle\Entity\Suprimible
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
trait ConEliminar
{
    /**
     * Crea el formulario de eliminación.
     */
    protected function CrearFormEliminar($id)
    {
        return $this->createFormBuilder(array('id' => $id))->add('id', 'hidden')->getForm();
    }
    
    /**
     * @Route("eliminar/{id}")
     * @Template("TapirBaseBundle:Default:eliminar.html.twig")
     */
    public function eliminarAction(Request $request, $id)
    {
        $deleteForm = $this->CrearFormEliminar($id);
        
        $em = $this->getEm();
        $entity = $em->getRepository($this->VendorName . $this->BundleName . 'Bundle:' . $this->EntityName)->find($id);
        
        if (! $entity) {
            throw $this->createNotFoundException('No se puede encontrar la entidad.');
        } else {
            $buscadorDeRelaciones = new \Tapir\BaseBundle\Helper\BuscadorDeRelaciones($em);
        }
        
        return $this->ArrastrarVariables(
            $request, 
            array(
                'entity' => $entity, 
                'create' => $id ? false : true, 
                'delete_form' => $deleteForm->createView(), 
                'tiene_asociaciones' => $buscadorDeRelaciones->tieneAsociaciones($entity)));
    }
    
    /**
     * @Route("eliminar2/{id}")
     * @Template("TapirBaseBundle:Default:eliminar2.html.twig")
     * @Sensio\Bundle\FrameworkExtraBundle\Configuration\Method("POST")
     */
    public function eliminar2Action(Request $request, $id)
    {
        $form = $this->CrearFormEliminar($id);
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            $em = $this->getEm();
            $entity = $em->getRepository($this->VendorName . $this->BundleName . 'Bundle:' . $this->EntityName)->find(
                $id);
            
            if (in_array('Tapir\BaseBundle\Entity\Suprimible', class_uses($entity))) {
                // Es suprimible (soft-deletable), lo marco como borrado, pero no lo borro
                $entity->Suprimir();
                $em->persist($entity);
                $em->flush();
                $this->get('session')->getFlashBag()->add('info', 'Se suprimió el elemento "' . $entity . '".');
                return $this->afterEliminar($request, $entity, true);
            } else 
                if (in_array('Tapir\BaseBundle\Entity\Eliminable', class_uses($entity))) {
                    // Es eliminable... lo elimino de verdad
                    $em->remove($entity);
                    $em->flush();
                    $this->get('session')->getFlashBag()->add('info', 'Se eliminó el elemento "' . $entity . '".');
                    return $this->afterEliminar($request, $entity, true);
                } else {
                    // No es eliminable ni suprimible... no se puede borrar
                    $this->get('session')->getFlashBag()->add(
                        'info', 
                        'No se puede eliminar el elemento "' . $entity . '".');
                }
        }
        
        return $this->afterEliminar($request, $entity);
    }
    
    /**
     * Este método se dispara después de eliminar una entidad.login
     *
     * @param bool $eliminado
     *            Indica si el elemento fue eliminado.
     */
    public function afterEliminar(Request $request, $entity, $eliminado = false)
    {
        return $this->redirect(
            $this->generateUrl($this->obtenerRutaBase('listar'), $this->ArrastrarVariables($request, null, false)));
    }
}

<?php
namespace Tapir\AbmBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Trait que agrega la capacidad de eliminar entidades.
 *
 * La entidad controlada por el controlador debe ser Eliminable o Suprimible.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 *
 * @see \Tapir\BaseBundle\Entity\Eliminable Eliminable
 * @see \Tapir\BaseBundle\Entity\Suprimible Suprimible
 */
trait ConEliminar
{
    /**
     * Crea el formulario de eliminación.
     *
     * @param integer $id ID de la entidad que se está procesando.
     */
    protected function CrearFormEliminar($id)
    {
        return $this->createFormBuilder(array('id' => $id))->add('id', 'Symfony\Component\Form\Extension\Core\Type\HiddenType')->getForm();
    }

    /**
     * @Route("eliminar/")
     * @Template("TapirAbmBundle::eliminar.html.twig")
     */
    public function eliminarAction(Request $request)
    {
        $id = $this->ObtenerVariable($request, 'id');
        $FormularioEliminar = $this->CrearFormEliminar($id);

        $em = $this->getEm();
        $Entidad = $em->getRepository($this->VendorName . $this->BundleName . 'Bundle:' . $this->EntityName)->find($id);

        if (!$Entidad) {
            throw $this->createNotFoundException('No se puede encontrar la entidad.');
        } else {
            $BuscadorDeRelaciones = new \Tapir\BaseBundle\Helper\BuscadorDeRelaciones($em);
        }

        $res = $this->ConstruirResultado(new \Tapir\AbmBundle\Helper\Resultados\ResultadoEliminarAction($this), $request);
        $res->Entidad = $Entidad;
        $res->FormularioEliminar = $FormularioEliminar->createView();
        $res->Relaciones = $BuscadorDeRelaciones->BuscarAsociaciones($Entidad);
        $res->TieneRelaciones = count($res->Relaciones) > 0;
        
        return array('res' => $res);
        
        return $this->ArrastrarVariables($request, array(
            'entity' => $Entidad,
            'create' => $id ? false : true,
            'delete_form' => $FormularioEliminar->createView(),
            'tiene_asociaciones' => $BuscadorDeRelaciones->TieneAsociaciones($Entidad)));
    }

    /**
     * @Route("eliminar2/")
     * @Template("TapirAbmBundle::eliminar2.html.twig")
     * @Sensio\Bundle\FrameworkExtraBundle\Configuration\Method("POST")
     */
    public function eliminar2Action(Request $request)
    {
        $id = $this->ObtenerVariable($request, 'id');
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
            } else {
                if (in_array('Tapir\BaseBundle\Entity\Eliminable', class_uses($entity))) {
                    // Es eliminable... lo elimino de verdad
                    $em->remove($entity);
                    $em->flush();
                    $this->get('session')->getFlashBag()->add('info', 'Se eliminó el elemento "' . $entity . '".');
                    return $this->afterEliminar($request, $entity, true);
                } else {
                    // No es eliminable ni suprimible... no se puede borrar
                    $this->get('session')->getFlashBag()->add('info',
                        'No se puede eliminar el elemento "' . $entity . '".');
                }
            }
        }
        return $this->afterEliminar($request, $entity);
    }

    /**
     * Este método se dispara después de eliminar una entidad.login
     *
     * @param bool Indica si el elemento fue eliminado.
     */
    public function afterEliminar(Request $request, $entity, $eliminado = false)
    {
        return $this->redirect(
            $this->generateUrl($this->obtenerRutaBase('listar'), $this->ArrastrarVariables($request, null, false)));
    }
}

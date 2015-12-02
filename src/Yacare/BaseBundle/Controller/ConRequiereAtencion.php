<?php
namespace Yacare\BaseBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Agrega la capacidad de marcar y desmarcar entidades como que requieren atención.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 * 
 * @see \Yacare\BaseBundle\Entity\ConRequiereAtencion
 */
trait ConRequiereAtencion
{
    /**
     * @Route("atencion/")
     */
    public function atencionAction(Request $request)
    {
        $id = $this->ObtenerVariable($request, 'id');
        $valor = $this->ObtenerVariable($request, 'valor');
        $em = $this->getDoctrine()->getManager();
        $entity = $this->ObtenerEntidadPorId($id);

        if (in_array('Yacare\BaseBundle\Entity\ConRequiereAtencion', class_uses($entity))) {
            // Es archivable
            $entity->setRequiereAtencion($valor);
            $em->persist($entity);
            $em->flush();
        }
        
        $accion = $this->ObtenerVariable($request, 'accion');
        if(!$accion) {
            $accion = 'listar';
        }
        return $this->redirect(
            $this->generateUrl($this->obtenerRutaBase($accion), $this->ArrastrarVariables($request, array('id' => $id), false)));
    }

    /**
     * Este método se dispara después de marcar o desmarcar una entidad.
     */
    public function afterRequiereAtencion($request, $entity, $requierAtencion = false)
    {
        return $this->redirect(
            $this->generateUrl($this->obtenerRutaBase('listar'), $this->ArrastrarVariables($request, null, false)));
    }
}

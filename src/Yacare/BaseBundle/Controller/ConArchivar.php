<?php
namespace Yacare\BaseBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Agrega la capacidad de archivar y desarchivar.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 * @see \Tapir\BaseBundle\Entity\Archivable TapirBasebundle:Archivable
 */
trait ConArchivar
{
    /**
     * @Route("desarchivar/")
     */
    public function desarchivarAction(Request $request)
    {
        $id = $this->ObtenerVariable($request, 'id');
        $em = $this->getDoctrine()->getManager();
        $entity = $this->ObtenerEntidadPorId($id);

        if (in_array('Tapir\BaseBundle\Entity\Archivable', class_uses($entity))) {
            // Es archivable
            $entity->setArchivado(0);
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('info', 'Se desarchivó el elemento "' . $entity . '".');

            return $this->afterArchivar($entity, false);
        }
        return $this->afterArchivar($entity);
    }

    /**
     * @Route("archivar/")
     */
    public function archivarAction(Request $request)
    {
        $id = $this->ObtenerVariable($request, 'id');
        $em = $this->getDoctrine()->getManager();
        $entity = $this->ObtenerEntidadPorId($id);

        if (in_array('Tapir\BaseBundle\Entity\Archivable', class_uses($entity))) {
            // Es archivable
            $entity->Archivar();
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('info', 'Se archivó el elemento "' . $entity . '".');

            return $this->afterArchivar($request, $entity, true);
        }
        return $this->afterArchivar($request, $entity);
    }

    /**
     * Este método se dispara después de archivar o desarchivar una entidad.
     */
    public function afterArchivar($request, $entity, $archivado = false)
    {
        return $this->redirectToRoute($this->obtenerRutaBase('listar'), $this->ArrastrarVariables($request, null, false));
    }
}

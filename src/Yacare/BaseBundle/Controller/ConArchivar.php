<?php
namespace Yacare\BaseBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

trait ConArchivar
{

    /**
     * @Sensio\Bundle\FrameworkExtraBundle\Configuration\Route("desarchivar/{id}")
     */
    public function desarchivarAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $this->obtenerEntidadPorId($id);
        
        if (in_array('Tapir\BaseBundle\Entity\Archivable', class_uses($entity))) {
            // Es archivable
            $entity->setArchivado(0);
            $em->persist($entity);
            $em->flush();
            $this->get('session')
                ->getFlashBag()
                ->add('info', 'Se desarchivó el elemento "' . $entity . '".');
            return $this->afterArchivar($entity, false);
        }
        
        return $this->afterArchivar($entity);
    }

    /**
     * @Sensio\Bundle\FrameworkExtraBundle\Configuration\Route("archivar/{id}")
     */
    public function archivarAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $this->obtenerEntidadPorId($id);
        
        if (in_array('Tapir\BaseBundle\Entity\Archivable', class_uses($entity))) {
            // Es archivable
            $entity->Archivar();
            $em->persist($entity);
            $em->flush();
            $this->get('session')
                ->getFlashBag()
                ->add('info', 'Se archivó el elemento "' . $entity . '".');
            return $this->afterArchivar($entity, true);
        }
        
        return $this->afterArchivar($entity);
    }

    /**
     * Este método se dispara después de archivar una entidad.
     *
     * @param bool $archivado
     *            Indica si el elemento fue archivado.
     */
    public function afterArchivar($entity, $archivado = false)
    {
        return $this->redirect(
            $this->generateUrl($this->obtenerRutaBase('listar'), $this->ArrastrarVariables($request, null, false)));
    }
}
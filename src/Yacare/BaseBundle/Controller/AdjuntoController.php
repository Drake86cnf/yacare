<?php

namespace Yacare\BaseBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("adjunto/")
 */
class AdjuntoController extends YacareBaseController
{
    /**
     * @Route("ver/{id}")
     */
    public function verAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('YacareBaseBundle:Adjunto')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se puede cargar la entidad.');
        }

        $adjunto_contenido = file_get_contents($entity->getRutaCompleta() . $entity->getToken());

        $response = new \Symfony\Component\HttpFoundation\Response($adjunto_contenido, 200, array(
            'Content-Type' => $entity->getTipoMime(),
            'Content-Length' => strlen($adjunto_contenido),
            'Content-Disposition' => 'filename="' . $entity->getNombre() . '"',
        ));

        return $response;
    }
}

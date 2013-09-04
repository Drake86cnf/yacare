<?php

namespace Yacare\BaseBundle\Controller;

trait ConImagen {
    /**
     * @Sensio\Bundle\FrameworkExtraBundle\Configuration\Route("imagen/{id}")
     */
    public function imagenAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        /* @var $entity Document */
        $entity = $em->getRepository('Yacare' . $this->BundleName . 'Bundle:' . $this->EntityName)->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Document entity.');
        }

        $imagen_contenido = stream_get_contents($entity->getImagen());

        $response = new \Symfony\Component\HttpFoundation\Response($imagen_contenido, 200, array(
            'Content-Type' => 'image/png',
            'Content-Length' => strlen($imagen_contenido),
            'Content-Disposition' => 'filename="' . 'Yacare' . $this->BundleName . 'Bundle_' . $this->EntityName . '_' . $entity->getId() . '.png"',
        ));

        return $response;
    }
}
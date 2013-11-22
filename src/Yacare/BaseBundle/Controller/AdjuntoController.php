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
     * @Route("listar/{tipo}/{id}")
     * @Template()
     */
    public function listarAction($tipo, $id)
    {
        $em = $this->getDoctrine()->getManager();
       
        $entities = $entity = $em->getRepository('YacareBaseBundle:Adjunto')->findBy(array(
            'EntidadTipo' => $tipo,
            'EntidadId' => $id
        ));
        
        return $this->ArrastrarVariables(array(
            'entities' => $entities,
        ));
    }
    
    /**
     * @Route("descargar/{token}")
     */
    public function descargarAction($token)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('YacareBaseBundle:Adjunto')->findOneBy(array('Token' => $token));

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
    
    
    /**
     * @Route("ver/{token}")
     * @Template()
     */
    public function verAction($token)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('YacareBaseBundle:Adjunto')->findOneBy(array('Token' => $token));

        if (!$entity) {
            throw $this->createNotFoundException('No se puede cargar la entidad.');
        }

        return $this->ArrastrarVariables(array(
            'entity' => $entity,
        ));
    }
}

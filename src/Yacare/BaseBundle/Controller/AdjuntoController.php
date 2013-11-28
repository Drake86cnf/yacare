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
     * @Route("miniatura/{token}")
     */
    public function miniaturaAction($token, $ancho = null)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('YacareBaseBundle:Adjunto')->findOneBy(array('Token' => $token));

        if (!$entity) {
            throw $this->createNotFoundException('No se puede cargar la entidad.');
        }
        
        $imagen_tipo = $entity->getTipoMime();
        switch($entity->getTipoMime()) {
            case 'image/jpg':
            case 'image/jpeg':
            case 'image/png':
            case 'image/gif':
            case 'image/svg':
                $imagemanagerResponse = $this->container
                    ->get('liip_imagine.controller')
                        ->filterAction(
                            $this->getRequest(),
                            $entity->getRutaRelativa() . $entity->getToken(),      // original image you want to apply a filter to
                            'thumb256'              // filter defined in config.yml
                );

                // string to put directly in the "src" of the tag <img>
                $cacheManager = $this->container->get('liip_imagine.cache.manager');
                $ArchivoImagen = $cacheManager->getBrowserPath($entity->getRutaRelativa() . $entity->getToken(), 'thumb256');
                $ArchivoImagen = str_replace('/app_dev.php', '', $ArchivoImagen);
                $imagen_tipo = 'image/jpeg';
                break;
            case 'application/pdf':
                $ArchivoImagen = '/bundles/yacarebase/img/mime/pdf.png';
                break;
            default:
                $ArchivoImagen = '/bundles/yacarebase/img/mime/pdf.png';
                break;
        }

        $imagen_conenido = file_get_contents($this->get('kernel')->getRootDir() . '/../web' . $this->getRequest()->getBasePath() . $ArchivoImagen);

        $response = new \Symfony\Component\HttpFoundation\Response($imagen_conenido, 200, array(
            'Content-Type' => $imagen_tipo,
            'Content-Length' => strlen($imagen_conenido),
            'Content-Disposition' => 'filename="' . $entity->getNombre() . '"',
        ));

        return $response;
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
            'Content-Disposition' => 'attachment; filename="' . $entity->getNombre() . '"',
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

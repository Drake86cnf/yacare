<?php

namespace Yacare\BaseBundle\Controller;

trait ConImprimir 
{
     /**
     * @Sensio\Bundle\FrameworkExtraBundle\Configuration\Route("imprimir/{id}")
     * @Sensio\Bundle\FrameworkExtraBundle\Configuration\Template()
     */
    public function imprimirAction($id)
    {
        $request = $this->getRequest();
        $fmt = $request->query->get('fmt');
        if(!$fmt)
            $fmt = 'application/pdf';
        
        $fmt = str_replace(' ', '/', $fmt);
        
        $tpl = $request->query->get('tpl');
        if(!$tpl)
            $tpl = 'imprimir';
        
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('Yacare' . $this->BundleName . 'Bundle:' . $this->EntityName)->find($id);
        if (!$entity)
            throw $this->createNotFoundException('No se puede encontrar la entidad.');

        $impresionEnCache = $em->getRepository('YacareBaseBundle:Impresion')->findBy(array(
            'EntidadTipo' => $this->BundleName . '/' . $this->EntityName,
            'EntidadId' => $entity->getId(),
            'EntidadVersion' => $entity->getVersion(),
            'TipoMime' => $fmt
        ));

        if(!$impresionEnCache) {
            // La impresión NO está en caché... la genero y la guardo en el cache
            // en principio la guardo sin contenido (placeholder), para obtener un id
            $impresionEnCache = new \Yacare\BaseBundle\Entity\Impresion();
            $impresionEnCache->setEntidadTipo($this->BundleName . '/' . $this->EntityName);
            $impresionEnCache->setEntidadId($entity->getId());
            $impresionEnCache->setEntidadVersion($entity->getVersion());
            $impresionEnCache->setTipoMime($fmt);
            $impresionEnCache->setContenido('placeholder');
            $em->persist($impresionEnCache);
            $em->flush();
            $em->refresh($impresionEnCache);

            // Ahora genero el contenido y guardo nuevamente la impresión
            $html = $this->renderView('Yacare' . $this->BundleName . 'Bundle:' . $this->EntityName . ':' . $tpl . '.html.twig', array(
                'id'       => $id,
                'entity'   => $entity,
                'impresion'=> $impresionEnCache,
                'fmt'      => 'text/html',
                'tpl'      => $tpl
            ));

            $impresionEnCache->setImagen($this->get('knp_snappy.image')->getOutputFromHtml($html));
            switch($fmt) {
                case 'text/html':
                    $impresionEnCache->setContenido($html);
                    break;
                case 'application/pdf':
                    $impresionEnCache->setContenido($this->get('knp_snappy.pdf')->getOutputFromHtml($html));
                    break;
            }

            $em->persist($impresionEnCache);
            $em->flush();
        } else {
            if(is_array($impresionEnCache))
                $impresionEnCache = $impresionEnCache[0];
        }

        $contenido = $impresionEnCache->getContenido();
        if(is_resource($contenido) && get_resource_type($contenido) == 'stream')
            $contenido = stream_get_contents($contenido);

        return new \Symfony\Component\HttpFoundation\Response(
            $contenido,
            200,
            array(
                'Content-Type'          => $impresionEnCache->getTipoMime(),
                'Content-Length'        => strlen($contenido),
                'Content-Disposition'   => 'filename="' . $this->EntityName . '_' . $entity->getId() . '.pdf"'
            )
        );
    }
}
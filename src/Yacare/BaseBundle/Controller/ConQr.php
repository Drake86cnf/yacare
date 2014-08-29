<?php
namespace Yacare\BaseBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

trait ConQr
{

    /**
     * @Route("qr/{id}")
     */
    public function qrAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('Yacare' . $this->BundleName . 'Bundle:' . $this->EntityName)->find($id);
        if (! $entity) {
            throw $this->createNotFoundException('No se puede encontrar la entidad.');
        }
        
        $ContenidoQr = $entity->getYri(true);
        
        ob_start();
        \PHPQRCode\QRcode::png($ContenidoQr);
        $imagen_contenido = ob_get_contents();
        ob_end_clean();
        
        $response = new \Symfony\Component\HttpFoundation\Response($imagen_contenido, 200, array(
            'Content-Type' => 'image/png',
            'Content-Length' => strlen($imagen_contenido),
            'Content-Disposition' => 'filename="' . 'Yacare' . $this->BundleName . 'Bundle_' . $this->EntityName . '_' . $entity->getId() . '.png"'
        ));
        
        return $response;
    }
}

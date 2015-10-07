<?php
namespace Yacare\BaseBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Controlador para gestionar archivos adjuntos asociados a otras entidades.
 *
 * Nota: los adjuntos se identifican por token y no por id para evitar nombres predecibles.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 *
 * @Route("adjunto/")
 */
class AdjuntoController extends \Tapir\BaseBundle\Controller\BaseController
{
    /**
     * Muestra una galería de adjuntos.
     *
     * @Route("listar/{tipo}/")
     * @Template()
     */
    public function listarAction(Request $request, $tipo)
    {
        $id = $this->ObtenerVariable($request, 'id');
        $em = $this->getEm();

        $entities = $em->getRepository('YacareBaseBundle:Adjunto')->findBy(
            array('EntidadTipo' => $tipo, 'EntidadId' => $id));

        return $this->ArrastrarVariables($request, array('entities' => $entities));
    }

    /**
     * @Route("miniatura/{token}")
     *
     public function miniaturaAction(Request $request, $token, $ancho = null)
     {
     $em = $this->getDoctrine()->getManager();

     $entity = $em->getRepository('YacareBaseBundle:Adjunto')->findOneBy(array('Token' => $token));

     if (! $entity) {
     throw $this->createNotFoundException('No se puede cargar la entidad.');
     }

     $imagen_tipo = $entity->getTipoMime();
     switch ($entity->getTipoMime()) {
     case 'image/jpg':
     case 'image/jpeg':
     case 'image/png':
     case 'image/gif':
     case 'image/svg':
     // string to put directly in the "src" of the tag <img>
     $cacheManager = $this->container->get('liip_imagine.cache.manager');
     $ArchivoImagen = $cacheManager->getBrowserPath($entity->getRutaRelativa() . $entity->getToken(),
     'thumb256');
     $ArchivoImagen = str_replace('/app_dev.php', '', $ArchivoImagen);
     $imagen_tipo = 'image/jpeg';
     break;
     case 'application/pdf':
     $ArchivoImagen = '/bundles/yacarebase/img/oxygen/256x256/mimetypes/application-pdf.png';
     break;
     case 'text/plain':
     $ArchivoImagen = '/bundles/yacarebase/img/oxygen/256x256/mimetypes/text-plain.png';
     break;
     default:
     $Extension = strtolower(pathinfo($entity->getNombre(), PATHINFO_EXTENSION));
     switch ($Extension) {
     case 'pdf':
     $ArchivoImagen = '/bundles/yacarebase/img/oxygen/256x256/mimetypes/application-pdf.png';
     break;
     case 'txt':
     $ArchivoImagen = '/bundles/yacarebase/img/oxygen/256x256/mimetypes/text-plain.png';
     break;
     case 'doc':
     case 'docx':
     $ArchivoImagen = '/bundles/yacarebase/img/oxygen/256x256/mimetypes/application-msword.png';
     break;
     case 'rtf':
     $ArchivoImagen = '/bundles/yacarebase/img/oxygen/256x256/mimetypes/application-rtf.png';
     break;
     case 'zip':
     case 'rar':
     case '7z':
     case 'tgz':
     $ArchivoImagen = '/bundles/yacarebase/img/oxygen/256x256/mimetypes/application-x-archive.png';
     break;
     case 'xml':
     $ArchivoImagen = '/bundles/yacarebase/img/oxygen/256x256/mimetypes/application-xml.png';
     break;
     case 'wav':
     $ArchivoImagen = '/bundles/yacarebase/img/oxygen/256x256/mimetypes/audio-x-wav.png';
     break;
     case 'csv':
     $ArchivoImagen = '/bundles/yacarebase/img/oxygen/256x256/mimetypes/text-csv.png';
     break;
     case 'htm':
     case 'html':
     $ArchivoImagen = '/bundles/yacarebase/img/oxygen/256x256/mimetypes/text-html.png';
     break;
     case 'rtf':
     $ArchivoImagen = '/bundles/yacarebase/img/oxygen/256x256/mimetypes/text-rtf.png';
     break;
     case 'xls':
     case 'xlsx':
     $ArchivoImagen = '/bundles/yacarebase/img/oxygen/256x256/mimetypes/application-vnd.ms-excel.png';
     break;
     case 'ods':
     $ArchivoImagen = '/bundles/yacarebase/img/oxygen/256x256/mimetypes/x-office-spreadsheet.png';
     break;
     case 'odt':
     $ArchivoImagen = '/bundles/yacarebase/img/oxygen/256x256/mimetypes/application-vnd.openxmlformats-officedocument.wordprocessingml.document.png';
     break;
     default:
     $ArchivoImagen = '/bundles/yacarebase/img/oxygen/256x256/mimetypes/unknown.png';
     break;
     }
     break;
     }

     $imagen_conenido = file_get_contents(
     $this->get('kernel')->getRootDir() . '/../web' . $request->getBasePath() . $ArchivoImagen);

     $response = new \Symfony\Component\HttpFoundation\Response($imagen_conenido, 200,
     array(
     'Content-Type' => $imagen_tipo,
     'Content-Length' => strlen($imagen_conenido),
     'Content-Disposition' => 'filename="' . $entity->getNombre() . '"'));

     return $response;
     }*/

    /**
     * Descargar el archivo adjunto.
     *
     * @Route("descargar/{token}")
     */
    public function descargarAction($token)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('YacareBaseBundle:Adjunto')->findOneBy(array('Token' => $token));

        if (! $entity) {
            throw $this->createNotFoundException('No se puede cargar la entidad.');
        }

        $adjunto_contenido = file_get_contents($entity->getRutaCompleta() . $entity->getToken());

        $response = new \Symfony\Component\HttpFoundation\Response($adjunto_contenido, 200, array(
            'Content-Type' => $entity->getTipoMime(),
            'Content-Length' => strlen($adjunto_contenido),
            'Content-Disposition' => 'attachment; filename="' . $entity->getNombre() . '"'));

        return $response;
    }

    /**
     * Ver el adjunto.
     *
     * @Route("ver/{token}")
     * @Template()
     */
    public function verAction(Request $request, $token)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('YacareBaseBundle:Adjunto')->findOneBy(array('Token' => $token));

        if (! $entity) {
            throw $this->createNotFoundException('No se puede cargar la entidad.');
        }

        return $this->ArrastrarVariables($request, array('entity' => $entity));
    }
}

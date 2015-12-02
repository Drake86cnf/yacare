<?php
namespace Yacare\BaseBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;

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
    use \Tapir\AbmBundle\Controller\ConVer;
    
    function IniciarVariables()
    {
        parent::IniciarVariables();
        //$this->BuscarPor = 'NombreVisible, Username, RazonSocial, DocumentoNumero, Cuilt, Email';
        //$this->OrderBy = 'r.NombreVisible';
        $this->ConservarVariables[] = 'tipo';
        $this->ConservarVariables[] = 'id';
    }
    
    /**
     * Muestra una galería de adjuntos.
     *
     * @Route("listar/{tipo}/")
     * @Template()
     */
    public function listarAction(Request $request, $tipo)
    {
        $em = $this->getEm();
        
        $id = $this->ObtenerVariable($request, 'id');
        
        $AdjuntoNuevo = new \Yacare\BaseBundle\Entity\Adjunto();
        $AdjuntoNuevo->setEntidadTipo($tipo);
        $AdjuntoNuevo->setEntidadId($id);
        $FormSubir = $this->CrearFormularioSubir($AdjuntoNuevo);

        $Entidades = $em->getRepository('YacareBaseBundle:Adjunto')->findBy(
            array('EntidadTipo' => $tipo, 'EntidadId' => $id, 'Suprimido' => 0));

        $res = $this->ConstruirResultado(new \Yacare\BaseBundle\Helper\Resultados\ResultadoAdjuntosListarAction($this), $request);
        $res->EntidadTipo = $tipo;
        $res->EntidadId = $id;
        $res->Entidades = $Entidades;
        $res->FormularioSubir = $FormSubir->createView();
        
        return array('res' => $res);
    }
    
    /**
     * Crea un formulario para subir archivos.
     */
    protected function CrearFormularioSubir($entity) {
        $editFormBuilder = $this->createFormBuilder($entity);
        $editFormBuilder->add('Nombre', 'file', array(
            'label' => 'Adjuntar archivo',
            'attr' => array('multiple' => 'multiple')
        ));
        
        $editForm = $editFormBuilder->getForm();
        return $editForm;
    }

    /**
     * Subir adjuntos.
     *
     * @Route("subir/{tipo}/")
     * @Template()
     */
    public function subirAction(Request $request, $tipo)
    {
        $em = $this->getEm();
        
        $id = $this->ObtenerVariable($request, 'id');
        $Archivos = $request->files;
        
        // $Archivo es una instancia de Symfony\Component\HttpFoundation\File\UploadedFile
        $AdjuntoNuevo = null;
        foreach ($Archivos as $Archivo) {
            $AdjuntoNuevo = new \Yacare\BaseBundle\Entity\Adjunto($Archivo, $tipo, $id);
            if($this->container->get('security.token_storage')->getToken()) {
                // Lo asocio al usuario conectado, si hay uno
                $AdjuntoNuevo->setPersona($this->container->get('security.token_storage')->getToken()->getUser());
            }
            $em->persist($AdjuntoNuevo);
            $em->flush();
        }
        
        if($AdjuntoNuevo) {
            return new JsonResponse(array('adjunto' => array(
                'id' => $AdjuntoNuevo->getId(),
                'token' => $AdjuntoNuevo->getToken()
            )));
        } else {
            return new JsonResponse(array('error' => 'Error'));
        }
        
        //return $this->ArrastrarVariables($request, array('tipo' => $tipo, 'id' => $id));
        
        
        
        //return $this->redirectToRoute($this->obtenerRutaBase('listar'),
        //    $this->ArrastrarVariables($request, array('tipo' => $tipo, 'id' => $id), false));
    }
    
    /**
     * Descargar el archivo adjunto.
     *
     * @Route("descargar/{token}")
     */
    public function descargarAction(Request $request, $token)
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
     * Eliminar el archivo adjunto.
     *
     * @Route("eliminar/{token}")
     * @Template()
     */
    public function eliminarAction(Request $request, $token)
    {
        $em = $this->getDoctrine()->getManager();
        
        $tipo = $this->ObtenerVariable($request, 'tipo');
        $id = $this->ObtenerVariable($request, 'id');
    
        $entity = $em->getRepository('YacareBaseBundle:Adjunto')->findOneBy(array('Token' => $token));
        
        if (! $entity) {
            throw $this->createNotFoundException('No se puede cargar la entidad.');
        }
        
        $formElminiar = $this->CrearFormEliminar($entity);
        return $this->ArrastrarVariables($request, array(
            'entity' => $entity,
            'tipo' => $tipo,
            'id' => $id,
            'delete_form' => $formElminiar->createView()
        ));
    }
    
    /**
     * @Route("eliminar2/{token}")
     * @Sensio\Bundle\FrameworkExtraBundle\Configuration\Method("POST")
     */
    public function eliminar2Action(Request $request, $token)
    {
        $tipo = $this->ObtenerVariable($request, 'tipo');
        $id = $this->ObtenerVariable($request, 'id');
        
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('YacareBaseBundle:Adjunto')->findOneBy(array('Token' => $token));
        
        $formElminiar = $this->CrearFormEliminar($entity);
        $formElminiar->handleRequest($request);
    
        if ($formElminiar->isValid()) {
            if (in_array('Tapir\BaseBundle\Entity\Suprimible', class_uses($entity))) {
                // Es suprimible (soft-deletable), lo marco como borrado, pero no lo borro
                $entity->Suprimir();
                $em->persist($entity);
                $em->flush();
                $this->get('session')->getFlashBag()->add('info', 'Se suprimió el elemento "' . $entity . '".');
            } else {
                if (in_array('Tapir\BaseBundle\Entity\Eliminable', class_uses($entity))) {
                    // Es eliminable... lo elimino de verdad
                    $em->remove($entity);
                    $em->flush();
                    $this->get('session')->getFlashBag()->add('info', 'Se eliminó el elemento "' . $entity . '".');
                } else {
                    // No es eliminable ni suprimible... no se puede borrar
                    $this->get('session')->getFlashBag()->add('info',
                        'No se puede eliminar el elemento "' . $entity . '".');
                }
            }
        }
        
        return $this->redirectToRoute($this->obtenerRutaBase('listar'),
            $this->ArrastrarVariables($request, array('tipo' => $tipo, 'id' => $id), false));
    }
    
    
    protected function CrearFormEliminar($entity) {
        return $this->createFormBuilder($entity)
            ->add('id', 'hidden')
            ->add('token', 'hidden')
            ->getForm();
    }
    

    /**
     * Ver detalles del adjunto.
     *
     * @Route("ver/{token}")
     * @Template()
     */
    public function verAction(Request $request, $token)
    {
        $em = $this->getDoctrine()->getManager();

        $Entidad = $em->getRepository('YacareBaseBundle:Adjunto')->findOneBy(array('Token' => $token));

        if (! $Entidad) {
            throw $this->createNotFoundException('No se puede cargar la entidad.');
        }
        
        $res = $this->ConstruirResultado(new \Tapir\AbmBundle\Helper\Resultados\ResultadoVerAction($this), $request);
        $res->Entidad = $Entidad;

        return array('res' => $res);
    }
    
    
    /**
     * Vista previa del adjunto.
     *
     * @Route("vistaprevia/{token}")
     * @Template()
     */
    public function vistapreviaAction(Request $request, $token)
    {
        $em = $this->getDoctrine()->getManager();
    
        $entity = $em->getRepository('YacareBaseBundle:Adjunto')->findOneBy(array('Token' => $token));
    
        if (! $entity) {
            throw $this->createNotFoundException('No se puede cargar la entidad.');
        }
        
        
        if($entity->EsTextoPlano() || $entity->EsHtml()) {
            $adjunto_contenido = file_get_contents($entity->getRutaCompleta() . $entity->getToken());
            return $this->ArrastrarVariables($request, array(
                'entity' => $entity,
                'contenido' => $adjunto_contenido
            ));
        } elseif($entity->SePuedeMostrarEnNavegador()) {
            $adjunto_contenido = file_get_contents($entity->getRutaCompleta() . $entity->getToken());
            $response = new \Symfony\Component\HttpFoundation\Response($adjunto_contenido, 200, array(
                'Content-Type' => $entity->getTipoMime(),
                'Content-Length' => strlen($adjunto_contenido),
                'Content-Disposition' => 'filename="' . $entity->getNombre() . '"'));
            return $response;
        } else {
            return $this->ArrastrarVariables($request, array('entity' => $entity));
        }
    }
}

<?php
namespace Yacare\BaseBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Agrega la capacidad de marcar y desmarcar entidades como que requieren atención.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 * 
 * @see \Yacare\BaseBundle\Entity\ConRequiereAtencion
 */
trait ConRequiereAtencion
{
    /**
     * @Route("atencion/")
     * @Template("YacareBaseBundle:ConRequiereAtencion:atencion.html.twig")
     */
    public function atencionAction(Request $request)
    {
        $id = $this->ObtenerVariable($request, 'id');
        $em = $this->getDoctrine()->getManager();
        $entity = $this->ObtenerEntidadPorId($id);
        
        $FormEditarBuilder = $this->createFormBuilder($entity);
        $FormEditarBuilder->add('RequiereAtencion', 'hidden', array(
            'label' => null,
            'required' => true));
        $FormEditarBuilder->add('RequiereAtencionObs', null, array(
            'label' => 'Razón',
            'required' => true));
        $FormEditar = $FormEditarBuilder->getForm();
        $FormEditar->handleRequest($request);

        if ($FormEditar->isValid()) {
            // Es archivable
            $em->persist($entity);
            $em->flush();
            return $this->guardarActionAfterSuccess($request, $entity);
        } else {
            $res = $this->ConstruirResultado(new \Tapir\AbmBundle\Helper\Resultados\ResultadoEditarGuardarAction($this),
                $request);
            $res->Entidad = $entity;
            $res->FormularioEditar = $FormEditar->createView();
            $res->AccionGuardar = 'atencion';
            return array('res' => $res);
        }
    }
}

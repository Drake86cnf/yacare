<?php
namespace Yacare\TramitesBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Controlador de trámites.
 *
 * No confundir con "tipos de trámite".
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 *
 * @see Yacare\TramitesBundle\Entity\Tramite
 *
 * @Route("tramite/")
 */
class TramiteController extends \Tapir\AbmBundle\Controller\AbmController
{
    use \Tapir\AbmBundle\Controller\ConAcciones;

    function IniciarVariables()
    {
        parent::IniciarVariables();

        $this->ConservarVariables[] = 'parent_id';
        $this->Where = 'r.Estado<90';
    }

    /**
     * @Route("cambiarestado/{id}/{reqid}/{estado}")
     * @Template()
     */
    public function cambiarestadoAction(Request $request, $id, $reqid, $estado)
    {
        $em = $this->getDoctrine()->getManager();

        $Tramite = $em->getRepository('\\Yacare\\TramitesBundle\\Entity\\Tramite')->find($id);
        if ($Tramite && $Tramite->getEstado() == 0) {
            $Tramite->setEstado(10);
            $em->persist($Tramite);
        }

        $EstadoRequisito = $em->getRepository('\\Yacare\\TramitesBundle\\Entity\\EstadoRequisito')->find($reqid);
        $EstadoRequisito->setEstado($estado);

        if ($EstadoRequisito->getEstado() == 100) {
            $EstadoRequisito->setFechaAprobado(new \DateTime());
        }
        $em->persist($EstadoRequisito);

        $em->flush();

        // $this->get('session')->getFlashBag()->add('info', (string)$entity . ' se marcó como ' .
        // \Yacare\TramitesBundle\Entity\EstadoRequisito::NombreEstado($estado));

        return $this->redirect(
            $this->generateUrl($this->obtenerRutaBase('ver'),
                $this->ArrastrarVariables($request, array('id' => $id), false)));
    }

    /**
     * @Route("terminar/")
     * @Template()
     */
    public function terminarAction(Request $request)
    {
        $id = $this->ObtenerVariable($request, 'id');
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('Yacare' . $this->BundleName . 'Bundle:' . $this->EntityName)->find($id);
        
        $Helper = new \Yacare\TramitesBundle\Helper\TramiteHelper($em);
        $resultado = $Helper->TerminarTramite($entity);

        return $this->ArrastrarVariables($request,
            array(
                'entity' => $entity,
                'mensaje' => $resultado['mensaje'],
                'comprob' => $resultado['comprobante'],
                'rutacomprob' => $resultado['rutacomprobante']
            ));
    }
    

    /* public function guardarActionPrePersist($entity, $editForm)
    {
        $res = parent::guardarActionPrePersist($entity, $editForm);

        if (! $entity->getTramiteTipo()) {
            // La propiedad TramiteTipo está en blanco... es normal al crear un trámite nuevo
            // Busco el TramiteTipo que corresponde a la clase y lo guardo
            $em = $this->getDoctrine()->getManager();

            $NombreClase = '\\' . get_class($entity);
            $TramiteTipo = $em->getRepository('YacareTramitesBundle:TramiteTipo')->findOneBy(
                array('Clase' => $NombreClase));

            $entity->setTramiteTipo($TramiteTipo);
        }

        $this->AsociarEstadosRequisitos($entity, null, $entity->getTramiteTipo()->getAsociacionRequisitos());

        return $res;
    } */


}

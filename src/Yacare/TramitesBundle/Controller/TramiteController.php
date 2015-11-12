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

    
    /**
     * @Route("adjuntos/")
     * @Template("YacareBaseBundle:Adjunto:listar.html.twig")
     */
    public function adjuntoslistarAction(Request $request)
    {
        $em = $this->getEm();
        
        $id = $this->ObtenerVariable($request, 'id');
        $Entidad = $this->ObtenerEntidadPorId($id);
        
        $AdjuntoNuevo = new \Yacare\BaseBundle\Entity\Adjunto();
        $AdjuntoNuevo->setEntidadTipo(get_class($Entidad));
        $AdjuntoNuevo->setEntidadId($Entidad->getId());
        
        $FormSubirBuilder = $this->createFormBuilder($Entidad);
        $FormSubirBuilder->add('Nombre', 'file', array(
            'label' => 'Adjuntar archivo',
            'data_class' => null,
            'attr' => array('multiple' => 'multiple')
        ));
        
        $FormSubir = $FormSubirBuilder->getForm();

        $Entidades = $em->getRepository('YacareBaseBundle:Adjunto')->findBy(
            array('EntidadTipo' => get_class($Entidad), 'EntidadId' => $Entidad->getId(), 'Suprimido' => 0));

        $res = $this->ConstruirResultado(new \Yacare\BaseBundle\Helper\Resultados\ResultadoAdjuntosListarAction($this), $request);
        $res->Entidad = $Entidad;
        $res->EntidadTipo = get_class($Entidad);
        $res->EntidadId = $Entidad->getId();
        $res->Entidades = $Entidades;
        $res->FormularioSubir = $FormSubir->createView();
        
        return array('res' => $res);
    }
}

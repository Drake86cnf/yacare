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
    use \Tapir\AbmBundle\Controller\ConVer;
    use \Tapir\AbmBundle\Controller\ConAcciones;

    function IniciarVariables()
    {
        parent::IniciarVariables();

        $this->ConservarVariables[] = 'parent_id';
        $this->Where = 'r.Estado<90';
    }

    /**
     * @Route("cambiarestado/{id}/{reqid}")
     * @Template()
     */
    public function cambiarestadoAction(Request $request, $id, $reqid)
    {
        $em = $this->getEm();

        $Estado = $this->ObtenerVariable($request, 'estado');
        $EstoyTrabajando = $this->ObtenerVariable($request, 'estoytrabajando');
        
        $Tramite = $em->getRepository('\\Yacare\\TramitesBundle\\Entity\\Tramite')->find($id);
        if ($Tramite && $Tramite->getEstado() == 0) {
            $Tramite->setEstado(10);
            $em->persist($Tramite);
        }

        print_r($Estado);
        print_r($EstoyTrabajando);
        
        $EstadoRequisito = $em->getRepository('\\Yacare\\TramitesBundle\\Entity\\EstadoRequisito')->find($reqid);
        if($Estado != null) {
            $EstadoRequisito->setEstado($Estado);
            if ($EstadoRequisito->getEstado() == 100) {
                $EstadoRequisito->setFechaAprobado(new \DateTime());
                $EstadoRequisito->setEstoyTrabajando(0);
            }
        }
        if($EstoyTrabajando != null) {
            $EstadoRequisito->setEstoyTrabajando($EstoyTrabajando);
        }

        $em->persist($EstadoRequisito);

        $em->flush();

        // $this->get('session')->getFlashBag()->add('info', (string)$entity . ' se marcó como ' .
        // \Yacare\TramitesBundle\Entity\EstadoRequisito::NombreEstado($estado));

        return $this->redirectToRoute($this->obtenerRutaBase('ver'),
            $this->ArrastrarVariables($request, array('id' => $id), false));
    }

    /**
     * @Route("terminar/")
     * @Template()
     */
    public function terminarAction(Request $request)
    {
        $em = $this->getEm();
        $id = $this->ObtenerVariable($request, 'id');
        $Tramite = $this->ObtenerEntidadPorId($id);
        
        $Helper = new \Yacare\TramitesBundle\Helper\TramiteHelper($this->container, $em);
        $resultado = $Helper->TerminarTramite($Tramite);
        
        $res = $this->ConstruirResultado(new \Tapir\AbmBundle\Helper\Resultados\ResultadoVerAction($this), $request);
        $res->Entidad = $Tramite;
        $res->Mensaje = $resultado['mensaje'];
        $res->Comprobante = $resultado['comprobante'];
        $res->RutaComprobante = $resultado['rutacomprobante'];

        return [ 'res' => $res ];
    }
    
    /**
     * @Route("adjuntos/asociar/")
     * @Template("YacareTramitesBundle:Tramite:adjuntos_asociar.html.twig")
     */
    public function adjuntosasociarAction(Request $request)
    {
        $em = $this->getEm();
        $id = $this->ObtenerVariable($request, 'id');
        
        $Tramite = $this->ObtenerEntidadPorId($id);
        
        $Adjuntos = $em->getRepository('YacareBaseBundle:Adjunto')->findBy(
            array('EntidadTipo' => get_class($Tramite), 'EntidadId' => $Tramite->getId(), 'Suprimido' => 0));
        
        // Veo si hay requisitos que asociar
        $RequisitoId = $this->ObtenerVariable($request, 'req');
        $AdjuntoId = $this->ObtenerVariable($request, 'adj');
        if($RequisitoId > 0 && $AdjuntoId > 0) {
            $Requisito = $em->getRepository('YacareTramitesBundle:EstadoRequisito')->find($RequisitoId);
            
            if($Requisito) {
                $HuboCambios = false;
                
                foreach($Adjuntos as $Adjunto) {
                    if($Adjunto->getId() == $AdjuntoId) {
                        $this->addFlash('info', 'Se asoció ' . $Adjunto . ' con ' . $Requisito);
                        
                        if($Requisito->getAdjuntos()->contains($Adjunto) == false) {
                            $Requisito->getAdjuntos()->add($Adjunto);
                            if($Requisito->getEstado() < 95) {
                                // Lo marco como presentado
                                $Requisito->setEstado(95);
                            }
                            $em->persist($Requisito);
                            $HuboCambios = true;
                        }
                        break;
                    }
                }

                if($HuboCambios) {
                    $em->flush();
                }
            }
        }
        
        $res = $this->ConstruirResultado(new \Yacare\BaseBundle\Helper\Resultados\ResultadoAdjuntosListarAction($this), $request);
        $res->Entidad = $Tramite;
        $res->EntidadTipo = get_class($Tramite);
        $res->EntidadId = $Tramite->getId();
        $res->Entidades = $Adjuntos;
        
        return array('res' => $res);
    }
    
    /**
     * @Route("adjuntos/listar/")
     * @Template("YacareTramitesBundle:Tramite:adjuntos_listar.html.twig")
     */
    public function adjuntoslistarAction(Request $request)
    {
        $em = $this->getEm();
        $id = $this->ObtenerVariable($request, 'id');
        
        $Tramite = $this->ObtenerEntidadPorId($id);
        
        $AdjuntoNuevo = new \Yacare\BaseBundle\Entity\Adjunto();
        $AdjuntoNuevo->setEntidadTipo(get_class($Tramite));
        $AdjuntoNuevo->setEntidadId($Tramite->getId());
        
        $FormSubirBuilder = $this->createFormBuilder($Tramite);
        $FormSubirBuilder->add('Nombre', 'Symfony\Component\Form\Extension\Core\Type\FileType', array(
            'label' => 'Adjuntar archivo',
            'data_class' => null,
            'attr' => array('multiple' => 'multiple')
        ));
        
        $FormSubir = $FormSubirBuilder->getForm();

        $RequisitoId = $this->ObtenerVariable($request, 'req');
        
        if($RequisitoId > 0) {
            foreach($Tramite->getEstadosRequisitos() as $Requisito) {
                if($Requisito->getId() == $RequisitoId) {
                    $Adjuntos = $Requisito->getAdjuntos();
                    break;
                }
            }
        } else {
            $Adjuntos = $em->getRepository('YacareBaseBundle:Adjunto')->findBy(
                array('EntidadTipo' => get_class($Tramite), 'EntidadId' => $Tramite->getId(), 'Suprimido' => 0));
        }

        $res = $this->ConstruirResultado(new \Yacare\BaseBundle\Helper\Resultados\ResultadoAdjuntosListarAction($this), $request);
        $res->Entidad = $Tramite;
        $res->EntidadTipo = get_class($Tramite);
        $res->EntidadId = $Tramite->getId();
        $res->Entidades = $Adjuntos;
        $res->FormularioSubir = $FormSubir->createView();

        return array('res' => $res);
    }
}

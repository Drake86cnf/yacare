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
 * @see Yacare\TramitesBundle\Entity\Tramite @Route("tramite/")
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class TramiteController extends \Tapir\BaseBundle\Controller\AbmController
{

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
        
        // $this->get('session')->getFlashBag()->add('info', (string)$entity . ' se marcó como ' . \Yacare\TramitesBundle\Entity\EstadoRequisito::NombreEstado($estado));
        
        return $this->redirect($this->generateUrl($this->obtenerRutaBase('ver'), 
                $this->ArrastrarVariables($request, array('id' => $id), false)));
    }
    

    /**
     * @Route("terminar/{id}")
     * @Template()
     */
    public function terminarAction(Request $request, $id = null)
    {
        $em = $this->getDoctrine()->getManager();
        
        $entity = $em->getRepository('Yacare' . $this->BundleName . 'Bundle:' . $this->EntityName)->find($id);
        
        if ($entity->getEstado() != 100) {
            $entity->setEstado(100);
            $entity->setFechaTerminado(new \DateTime());
            
            $Comprob = $this->EmitirComprobante($entity);
            if ($Comprob) {
                $Comprob->setTramiteOrigen($entity);
                $Comprob->setNumero($this->ObtenerProximoNumeroComprobante($Comprob));
                $em->persist($Comprob);
                
                $entity->setComprobante($Comprob);
            }
            
            $em->persist($entity);
            $em->flush();
            
            $mensaje = null;
        } else {
            $mensaje = 'El trámite ya estaba terminado.';
            $Comprob = $entity->getComprobante();
        }
        
        if ($Comprob) {
            $RutaComprob = \Tapir\BaseBundle\Helper\StringHelper::ObtenerRutaBase(
                $Comprob->getComprobanteTipo()->getClase());
        } else {
            $RutaComprob = null;
        }
        
        return $this->ArrastrarVariables($request, 
            array('entity' => $entity,'mensaje' => $mensaje,'comprob' => $Comprob,'rutacomprob' => $RutaComprob));
    }
    

    public function EmitirComprobante($tramite)
    {
        // Al finalizar un trámite, ver si es necesario emitir un comprobante
        $Comprob = null;
        
        $ComprobanteTipo = $tramite->getTramiteTipo()->getComprobanteTipo();
        if ($ComprobanteTipo) {
            // Tiene un tipo de comprobante asociado
            $Clase = $ComprobanteTipo->getClase();
            if ($Clase) {
                // Instancio un comprobante del tipo asociado
                $Comprob = new $Clase();
                $Comprob->setComprobanteTipo($ComprobanteTipo);
                
                if ($ComprobanteTipo->getPeriodoValidez()) {
                    // Este tipo de comprobante tiene un período de validez predeterminado
                    // Fecha de vencimiento: validez indicada por el comprobante, menos 1 día
                    $Venc = new \DateTime();
                    $Comprob->setVencimiento($Venc->add(new \DateInterval('P' . $ComprobanteTipo->getPeriodoValidez())));
                }
            }
        }
        
        return $Comprob;
    }
    

    public function ObtenerProximoNumeroComprobante($comprob)
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
            'SELECT MAX(c.Numero) FROM \Yacare\TramitesBundle\Entity\Comprobante c WHERE c.ComprobanteTipo=?1 AND c.NumeroPrefijo=?2');
        $query->setParameter(1, $comprob->getComprobanteTipo());
        $query->setParameter(2, $comprob->getNumeroPrefijo());
        $res = (int) $query->getResult(\Doctrine\ORM\Query::HYDRATE_SINGLE_SCALAR);
        return ++ $res;
    }
    

    public function guardarActionPrePersist($entity, $editForm)
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
        
        $this->AsociarEstadosRequisitos($entity, null, 
            $entity->getTramiteTipo()
                ->getAsociacionRequisitos());
        
        return $res;
    }
    

    protected function AsociarEstadosRequisitos($entity, $EstadoRequisitoPadre, $Asociaciones)
    {
        
        // Crear (en cero) los estados de los requisitos asociados a este trámite.
        foreach ($Asociaciones as $AsociacionRequisito) {
            // Primero busco para ver si ya existe
            $EstadoRequisito = null;
            if ($entity->getEstadosRequisitos()) {
                foreach ($entity->getEstadosRequisitos() as $EstReq) {
                    if ($EstReq->getAsociacionRequisito() === $AsociacionRequisito) {
                        // Ya existe, por lo tanto no lo agrego
                        $EstadoRequisito = $EstReq;
                        break;
                    }
                }
            }
            
            if ($EstadoRequisito == null) {
                // No existe, así que la creo
                $EstadoRequisito = new \Yacare\TramitesBundle\Entity\EstadoRequisito();
                $EstadoRequisito->setTramite($entity);
            }
            
            $EstadoRequisito->setAsociacionRequisito($AsociacionRequisito);
            $EstadoRequisito->setEstadoRequisitoPadre($EstadoRequisitoPadre);
            
            if (! $EstadoRequisito->getId()) {
                $entity->AgregarEstadoRequisito($EstadoRequisito);
            }
            
            if ($AsociacionRequisito->getRequisito()->getTipo() == 'tra') {
                // Es un trámite... asocio los sub-requisitos
                $SubTramiteTipo = $AsociacionRequisito->getRequisito()->getTramiteTipoEspejo();
                if ($SubTramiteTipo) {
                    $this->AsociarEstadosRequisitos($entity, $EstadoRequisito, 
                        $SubTramiteTipo->getAsociacionRequisitos());
                }
            }
        }
    }
}

<?php
namespace Yacare\TramitesBundle\Helper;

use Doctrine\ORM\Event\LifecycleEventArgs;

/**
 * Maneja los eventos "lyfecycle" para actuar ante ciertos cambios en los trámites.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class TramiteHelper extends \Yacare\BaseBundle\Helper\Helper
{

    function __construct($listener = null, $em = null)
    {
        parent::__construct($listener, $em);
    }

    public function PreUpdatePersist($entity, $args = null)
    {
        if (! $entity->getTramiteTipo()) {
            // La propiedad TramiteTipo está en blanco... es normal al crear un trámite nuevo
            // Busco el TramiteTipo que corresponde a la clase y lo guardo
            
            $NombreClase = '\\' . get_class($entity);
            $TramiteTipo = $this->em->getRepository('YacareTramitesBundle:TramiteTipo')->findOneBy(
                array('Clase' => $NombreClase));
            
            $entity->setTramiteTipo($TramiteTipo);
        }
        $this->AsociarEstadosRequisitos($entity, null, 
            $entity->getTramiteTipo()
                ->getAsociacionRequisitos());
    }

    /**
     * Crear (en cero) un estado para cada uno de los requisitos asociados a este trámite.
     *
     * @param \Yacare\TramitesBundle\Entity\Tramite             $entity
     * @param \Yacare\TramitesBundle\Entity\EstadoRequisito     $EstadoRequisitoPadre
     * @param \Yacare\TramitesBundle\Entity\AsociacionRequisito $Asociaciones
     */
    protected function AsociarEstadosRequisitos($entity, $EstadoRequisitoPadre, $Asociaciones)
    {
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
                    if ($SubTramiteTipo->getClase() != '\Yacare\TramitesBundle\Entity\TramiteSimple') {
                        $ClaseSubTramite = $SubTramiteTipo->getClase();
                        $NuevoSubTram = new $ClaseSubTramite();
                        $NuevoSubTram->setTramitePadre($entity);
                        $this->em->persist($NuevoSubTram);
                        $this->em->flush();
                    }
                    $this->AsociarEstadosRequisitos($entity, $EstadoRequisito, 
                        $SubTramiteTipo->getAsociacionRequisitos());
                }
            }
        }
    }

    /**
     * Termina un trámite, emitiendo un comprobante si es necesario.
     * 
     * @param Tramite $tramite
     */
    public function TerminarTramite($tramite)
    {
        $res = array();
        
        if ($tramite->getEstado() != 100) {
            $tramite->setEstado(100);
            $tramite->setFechaTerminado(new \DateTime());
            
            $Comprob = $this->EmitirComprobante($tramite);
            $res['comprobante'] = $Comprob;
            if ($Comprob) {
                $Comprob->setTramiteOrigen($tramite);
                $Comprob->setNumero($this->ObtenerProximoNumeroComprobante($Comprob));
                $this->em->persist($Comprob);
                
                $tramite->setComprobante($Comprob);
            }
            
            $this->em->persist($tramite);
            $this->em->flush();
            
            $res['mensaje'] = null;
        } else {
            $res['mensaje'] = 'El trámite ya estaba terminado.';
            $Comprob = $tramite->getComprobante();
            $res['comprobante'] = $Comprob;
        }
        
        if ($Comprob) {
            $res['rutacomprobante'] = \Tapir\BaseBundle\Helper\StringHelper::ObtenerRutaBase(
                $Comprob->getComprobanteTipo()->getClase());
        } else {
            $res['rutacomprobante'] = null;
        }
        
        return $res;
    }

    /**
     * Al finalizar un trámite, ver si es necesario emitir un comprobante.
     * 
     * @param Tramite $tramite
     */
    public function EmitirComprobante($tramite)
    {
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
                    $Comprob->setFechaValidezHasta(
                        $Venc->add(new \DateInterval('P' . $ComprobanteTipo->getPeriodoValidez())));
                }
            }
        }
        
        return $Comprob;
    }

    /**
     * Obtiene el próximo número para un comprobante, según el tipo de comprobante.
     * @param Comprobante $comprob
     * @return number El número correspondiente al próximo comprobante.
     */
    public function ObtenerProximoNumeroComprobante($comprob)
    {
        $query = $this->em->createQuery(
            'SELECT MAX(c.Numero) FROM \Yacare\TramitesBundle\Entity\Comprobante c WHERE c.ComprobanteTipo=?1
            AND c.NumeroPrefijo=?2');
        $query->setParameter(1, $comprob->getComprobanteTipo());
        $query->setParameter(2, $comprob->getNumeroPrefijo());
        $res = (int) $query->getResult(\Doctrine\ORM\Query::HYDRATE_SINGLE_SCALAR);
        
        return ++ $res;
    }
}

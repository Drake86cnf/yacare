<?php
namespace Yacare\TramitesBundle\Helper;

use Doctrine\ORM\Event\LifecycleEventArgs;

/**
 * Maneja los eventos "lyfecycle" para actuar ante ciertos cambios en los trámites.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class TramiteHelper
{
    public function LifecycleEvent(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $em = $args->getEntityManager();
        
        if (! $entity->getTramiteTipo()) {
            // La propiedad TramiteTipo está en blanco... es normal al crear un trámite nuevo
            // Busco el TramiteTipo que corresponde a la clase y lo guardo
            
            $NombreClase = '\\' . get_class($entity);
            $TramiteTipo = $em->getRepository('YacareTramitesBundle:TramiteTipo')->findOneBy(
                array('Clase' => $NombreClase));
            
            $entity->setTramiteTipo($TramiteTipo);
        }
        $this->AsociarEstadosRequisitos($entity, null, $entity->getTramiteTipo()->getAsociacionRequisitos());
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
                    $this->AsociarEstadosRequisitos($entity, $EstadoRequisito, 
                        $SubTramiteTipo->getAsociacionRequisitos());
                }
            }
        }
    }
}

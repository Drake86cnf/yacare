<?php
namespace Yacare\TramitesBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\Common\EventSubscriber;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;

use Yacare\TramitesBundle\Entity\ITramite;

/**
 * Escucha los eventos "lifecycle" de Doctrine para intervenir durante la creación o modificación de un Trámite
 * .
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class TramiteListener implements EventSubscriber
{
    private $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Interviene enn la creación de un trámite.
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if ($entity instanceof ITramite) {
            $this->TramiteCrearActualizar($args);
        }
    }

    public function preUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        if ($entity instanceof ITramite) {
            $this->TramiteCrearActualizar($args);
        }
    }


    protected function TramiteCrearActualizar(LifecycleEventArgs $args) {
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
     * @param unknown $entity
     * @param unknown $EstadoRequisitoPadre
     * @param unknown $Asociaciones
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

    public function getSubscribedEvents()
    {
        return [\Doctrine\ORM\Events::prePersist, \Doctrine\ORM\Events::preUpdate];
    }
}
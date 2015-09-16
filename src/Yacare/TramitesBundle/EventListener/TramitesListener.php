<?php
namespace Yacare\TramitesBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\Common\EventSubscriber;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use Yacare\TramitesBundle\Entity\ITramite;

/**
 * Escucha los eventos "lifecycle" de Doctrine para intervenir durante la creación o modificación de ciertas entidades.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class TramitesListener implements EventSubscriber
{
    private $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Interviene la creación de un trámite.
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        if ($entity instanceof ITramite) {
            // Capturo los eventos si la entidad es un trámite
            $Helper = new \Yacare\TramitesBundle\Helper\TramiteHelper();
            $Helper->LifecycleEvent($args);
        } elseif ($entity instanceof \Yacare\TramitesBundle\Entity\IEstadoRequisito) {
            // Capturo los eventos si la entidad es el estado de un requisito
            $Helper = new \Yacare\TramitesBundle\Helper\EstadoRequisitoHelper();
            $Helper->LifecycleEvent($args);
        }
    }

    public function preUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        if ($entity instanceof ITramite) {
            // Capturo los eventos si la entidad es un trámite
            $Helper = new \Yacare\TramitesBundle\Helper\TramiteHelper();
            $Helper->LifecycleEvent($args);
        } elseif ($entity instanceof \Yacare\TramitesBundle\Entity\IEstadoRequisito) {
            // Capturo los eventos si la entidad es el estado de un requisito
            $Helper = new \Yacare\TramitesBundle\Helper\EstadoRequisitoHelper();
            $Helper->LifecycleEvent($args);
        }
    }

    public function getSubscribedEvents()
    {
        return [\Doctrine\ORM\Events::prePersist, \Doctrine\ORM\Events::preUpdate];
    }
}

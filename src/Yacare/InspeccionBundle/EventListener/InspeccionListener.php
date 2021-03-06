<?php
namespace Yacare\InspeccionBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\Common\EventSubscriber;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;

/**
 * Escucha los eventos "lifecycle" de Doctrine para intervenir durante la creación o modificación de ciertas entidades.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class InspeccionListener implements EventSubscriber
{
    public $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        if ($entity instanceof \Yacare\InspeccionBundle\Entity\IActa) {
            // Capturo los eventos si la entidad es un acta.
            $Helper = new \Yacare\InspeccionBundle\Helper\ActaHelper($this);
            $Helper->LifecycleEvent($args);
        /* } elseif ($entity instanceof \Yacare\TramitesBundle\Entity\IActaTipo) {
            // Capturo los eventos si la entidad es un tipo de acta.
            $Helper = new \Yacare\TramitesBundle\Helper\TramiteTipoHelper($this);
            $Helper->LifecycleEvent($args); */
        }
    }

    public function preUpdate(LifecycleEventArgs $args)
    {
        return $this->prePersist($args);
    }

    public function getSubscribedEvents()
    {
        return [\Doctrine\ORM\Events::prePersist, \Doctrine\ORM\Events::preUpdate];
    }
}

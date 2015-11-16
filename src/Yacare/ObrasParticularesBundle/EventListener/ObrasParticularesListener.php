<?php
namespace Yacare\ObrasParticularesBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\Common\EventSubscriber;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;

/**
 * Escucha los eventos "lifecycle" de Doctrine para intervenir durante la creación o modificación de ciertas entidades.
 *
 * @author Ezequiel Riquelme <rezequiel.tdf@gmail.com>
 */
class ObrasParticularesListener implements EventSubscriber
{
    private $container;
    
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        if ($entity instanceof \Yacare\ObrasParticularesBundle\Entity\IActaObra) {
            // Capturo los eventos si la entidad es un acta.
            $Helper = new \Yacare\ObrasParticularesBundle\Helper\ActaObraHelper();
            $Helper->LifecycleEvent($args);
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

<?php
namespace Yacare\ObrasParticularesBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\Common\EventSubscriber;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use Doctrine\DBAL\Types\VarDateTimeType;

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
        if (is_a($entity, 'Yacare\ObrasParticularesBundle\Entity\ActaObra')) {
            // Capturo los eventos si la entidad es un acta.
            $Helper = new \Yacare\ObrasParticularesBundle\Helper\ActaObraHelper($this);
            $Helper->LifecycleEvent($args);
        } elseif (is_a($entity, 'Yacare\ObrasParticularesBundle\Entity\TramiteCat')) {
            // Capturo los eventos si la entidad es un tramitecat
            $Helper = new \Yacare\ObrasParticularesBundle\Helper\TramiteCatHelper();
            $Helper->LifecycleEvent($args);
        } elseif (is_a($entity, 'Yacare\ObrasParticularesBundle\Entity\TramitePlano')) {
            // Capturo los eventos si la entidad es un trámite de planos (mov. previas)
            $Helper = new \Yacare\ObrasParticularesBundle\Helper\TramitePlanoHelper();
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

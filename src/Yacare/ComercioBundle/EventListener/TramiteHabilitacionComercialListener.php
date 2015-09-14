<?php
namespace Yacare\ComercioBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\Common\EventSubscriber;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use Yacare\ComercioBundle\Entity\ITramiteHabilitacionComercial;

/**
 * Escucha los eventos "lifecycle" de Doctrine para intervenir durante la creación o modificación de un Trámite de
 * Habilitación Comercial.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class TramiteHabilitacionComercialListener implements EventSubscriber
{
    private $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Interviene enn la creación de un trámite de habilitación comercial.
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        //echo 'TramiteHC::prePersist ' . get_class($entity) . '!<br />';
        if (!($entity instanceof ITramiteHabilitacionComercial)) {
            return;
        }

        $Comercio = $entity->getComercio();
        if(!$Comercio->getTitular()) {
            // Si el comercio no tiene un titular, le asigno el mismo titular que el trámite de habilitación
            //echo 'Asignar titular<br />';
            $Comercio->setTitular($entity->getTitular());
        }
    }

    public function getSubscribedEvents()
    {
        return [\Doctrine\ORM\Events::prePersist, \Doctrine\ORM\Events::preUpdate];
    }
}

<?php
namespace Yacare\ComercioBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\OnFlushEventArgs;
use Doctrine\Common\EventArgs;
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
     * Interviene la creación de una entidad para generar un registro de auditoría.
     *
     * @param LifecycleEventArgs $eventArgs
     */
    public function prePersist(LifecycleEventArgs $eventArgs)
    {
        $em = $eventArgs->getEntityManager();
        $entity = $eventArgs->getEntity();
        if (!($entity instanceof ITramiteHabilitacionComercial)) {
            return;
        }

        $Comercio = $entityTramite->getComercio();

        echo (string)$Comercio;
        die(0);
    }


    /**
     * Devuelve true si la clase es auditable.
     *
     * @param ReflectionClass $reflClass
     * @return boolean True si la clase es auditable.
     */
    protected function isEntitySupported(\ReflectionClass $reflClass)
    {
        return \Tapir\BaseBundle\Helper\ClassHelper::UsaTrait($reflClass->getName(),
            'Tapir\BaseBundle\Entity\Auditable');
    }


    public function getSubscribedEvents()
    {
        return [\Doctrine\ORM\Events::prePersist];
    }
}

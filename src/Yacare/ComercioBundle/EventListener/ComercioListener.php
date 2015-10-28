<?php
namespace Yacare\ComercioBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\Common\EventSubscriber;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use Yacare\ComercioBundle\Entity\ITramiteHabilitacionComercial;

/**
 * Escucha los eventos "lifecycle" de Doctrine para intervenir durante la creación o modificación de ciertas entidades.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class ComercioListener implements EventSubscriber
{
    private $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        
        $entity = $args->getEntity();
        if ($entity instanceof \Yacare\ComercioBundle\Entity\ITramiteHabilitacionComercial) {
            // Capturo los eventos si la entidad es un trámite de habilitación comercial
            $Helper = new \Yacare\ComercioBundle\Helper\TramiteHabilitacionComercialHelper();
            $Helper->LifecycleEvent($args);
        } elseif ($entity instanceof IComercio) {
            // Capturo los eventos si la entidad es un comercio
            $Helper = new \Yacare\ComercioBundle\Helper\ComercioHelper();
            $Helper->LifecycleEvent($args);
        } elseif ($entity instanceof \Yacare\ComercioBundle\Entity\ICertificadoHabilitacionComercial) {
            // Capturo los eventos si la entidad es un certificado
            $Helper = new \Yacare\ComercioBundle\Helper\CertificadoHabilitacionComercialHelper();
            $Helper->LifecycleEvent($args);
        } elseif ($entity instanceof \Yacare\TramitesBundle\Entity\IEstadoRequisito) {
            $Tramite = $entity->getTramite();
            if ($Tramite instanceof \Yacare\ComercioBundle\Entity\ITramiteHabilitacionComercial) {
                // Capturo los eventos si la entidad es el estado de un requisito y el trámite asociado es un trámite
                // de habilitación comercial.
                $Helper = new \Yacare\ComercioBundle\Helper\EstadoRequisitoHelper();
                $Helper->LifecycleEvent($args);
            }
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

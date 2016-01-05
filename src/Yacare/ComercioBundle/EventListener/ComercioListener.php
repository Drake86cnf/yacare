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
    public $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function prePersist(LifecycleEventArgs $args)
    {        
        $entity = $args->getEntity();
        if (is_a($entity,'\Yacare\ComercioBundle\Entity\TramiteHabilitacionComercial')) {
            // Capturo los eventos si la entidad es un trámite de habilitación comercial
            $Helper = new \Yacare\ComercioBundle\Helper\TramiteHabilitacionComercialHelper($this);
            $Helper->LifecycleEvent($args);
        } elseif (is_a($entity, '\Yacare\ComercioBundle\Entity\Comercio')) {
            // Capturo los eventos si la entidad es un comercio
            $Helper = new \Yacare\ComercioBundle\Helper\ComercioHelper($this);
            $Helper->LifecycleEvent($args);
        } elseif (is_a($entity, '\Yacare\ComercioBundle\Entity\ActaComercio')) {
            // Capturo los eventos si la entidad es un acta comercio
            $Helper = new \Yacare\ComercioBundle\Helper\ActaComercioHelper($this);
            $Helper->LifecycleEvent($args);
        } elseif (is_a($entity, '\Yacare\ComercioBundle\Entity\CertificadoHabilitacionComercial')) {
            // Capturo los eventos si la entidad es un certificado
            $Helper = new \Yacare\ComercioBundle\Helper\CertificadoHabilitacionComercialHelper($this);
            $Helper->LifecycleEvent($args);
        } elseif (is_a($entity, '\Yacare\TramitesBundle\Entity\EstadoRequisito')){
            $Tramite = $entity->getTramite();
            if (is_a($Tramite,'\Yacare\ComercioBundle\Entity\TramiteHabilitacionComercial')) {
                // Capturo los eventos si la entidad es el estado de un requisito y el trámite asociado es un trámite
                // de habilitación comercial.
                $Helper = new \Yacare\ComercioBundle\Helper\EstadoRequisitoHelper($this);
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

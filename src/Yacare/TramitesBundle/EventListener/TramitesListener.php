<?php
namespace Yacare\TramitesBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PostFlushEventArgs;
use Doctrine\Common\EventSubscriber;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;

/**
 * Escucha los eventos "lifecycle" de Doctrine para intervenir durante la creación o modificación de ciertas entidades.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class TramitesListener implements EventSubscriber
{
    protected $container;
    protected $TramiteHelper = null, $TramiteTipoHelper = null, $EstadoRequisitoHelper = null;
    
    public $EntidadesRelacionadas = array();
    
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        if (is_a($entity, '\Yacare\TramitesBundle\Entity\Tramite')) {
            // Capturo los eventos si la entidad es un trámite
            if(!$this->TramiteHelper) {
                $this->TramiteHelper = new \Yacare\TramitesBundle\Helper\TramiteHelper($this);
            }
            $this->TramiteHelper->LifecycleEvent($args);
        } elseif (is_a($entity, '\Yacare\TramitesBundle\Entity\TramiteTipo')) {
            // Capturo los eventos si la entidad es un tipo de trámite
            if(!$this->TramiteTipoHelper) {
                $this->TramiteTipoHelper = new \Yacare\TramitesBundle\Helper\TramiteTipoHelper($this);
            }
            $this->TramiteTipoHelper->LifecycleEvent($args);
        } elseif (is_a($entity, '\Yacare\TramitesBundle\Entity\EstadoRequisito')) {
            // Capturo los eventos si la entidad es el estado de un requisito
            if(!$this->EstadoRequisitoHelper) {
                $this->EstadoRequisitoHelper = new \Yacare\TramitesBundle\Helper\EstadoRequisitoHelper($this);
            }
            $this->EstadoRequisitoHelper->LifecycleEvent($args);
        }
    }

    public function preUpdate(LifecycleEventArgs $args)
    {
        return $this->prePersist($args);
    }
    
    public function postFlush(PostFlushEventArgs $args)
    {
        if(count($this->EntidadesRelacionadas) > 0) {
            $em = $args->getEntityManager();
            foreach($this->EntidadesRelacionadas as $Entidad) {
                $em->persist($Entidad);
            }
            $this->EntidadesRelacionadas = array();
            $em->flush();
        }
    }

    public function getSubscribedEvents()
    {
        return [\Doctrine\ORM\Events::prePersist, \Doctrine\ORM\Events::preUpdate, \Doctrine\ORM\Events::postFlush];
    }
}

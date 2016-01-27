<?php
namespace Tapir\BaseBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PostFlushEventArgs;
use Doctrine\Common\EventSubscriber;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;

/**
 * Escucha los eventos "lifecycle" de Doctrine para generar registros de auditoría para aquellas entidades que se
 * registren.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
abstract class AbstractListener implements EventSubscriber
{
    protected $container;
    protected $Helpers;
    
    public function __construct(Container $container)
    {
        $this->container = $container;
    }
    
    public function prePersist(LifecycleEventArgs $args)
    {
        $Entidad = $args->getEntity();
        foreach($this->Helpers as $Clase => $Helper) {
            if (is_a($Entidad, $Clase)) {
                // Hay un helper suscripto para esta clase
                if(is_string($Helper)) {
                    // Tengo el nombre de la clase del helper, creo una instancia
                    $TmpHelper = new $Helper($this->container);
                    $this->Helpers[$Clase] = $TmpHelper;
                    $TmpHelper->LifecycleEvent($args);
                    break;
                } elseif(is_a($Helper, 'Tapir\BaseBundle\Helper\AbstractHelper')) {
                    // Tengo la instancia...
                    $Helper->LifecycleEvent($args);
                    break;
                } else {
                    throw new \Exception('Tipo de Helper no reconocido: ' . get_class($Helper));
                }
            }
        }
    }
    
    public function preUpdate(LifecycleEventArgs $args)
    {
        return $this->prePersist($args);
    }
    
    public function postFlush(PostFlushEventArgs $args)
    {
        $em = $args->getEntityManager();
        // Recorro los helpers y hago un flush() de las entidades relacionadas
        foreach($this->Helpers as $Clase => $Helper) {
            if(is_a($Helper, 'Tapir\BaseBundle\Helper\AbstractHelper') && count($Helper->EntidadesRelacionadas) > 0) {
                foreach($Helper->EntidadesRelacionadas as $Entidad) {
                    $em->persist($Entidad);
                }
                $Helper->EntidadesRelacionadas = array();
                $em->flush();
            }
        }
    }
    
    public function getSubscribedEvents()
    {
        return [\Doctrine\ORM\Events::prePersist, \Doctrine\ORM\Events::preUpdate, \Doctrine\ORM\Events::postFlush];
    }
}

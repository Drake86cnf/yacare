<?php
namespace Yacare\TramitesBundle\Helper;

use Doctrine\ORM\Event\LifecycleEventArgs;

/**
 * Maneja los eventos "lyfecycle" para actuar ante ciertos cambios en los tipos de trámite.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class TramiteTipoHelper extends \Yacare\BaseBundle\Helper\Helper
{
    function __construct($em = null) {
        parent::__construct($em);
    }
    
    public function PreUpdatePersist($entity, $args = null) {
        // Crear o actualizar un requisito asociado
        $RequisitoEspejo = $entity->getRequisitoEspejo();
        if (! $RequisitoEspejo) {
            $RequisitoEspejo = new \Yacare\TramitesBundle\Entity\Requisito();
            $RequisitoEspejo->setTramiteTipoEspejo($entity);
        }
        
        $RequisitoEspejo->setTipo('tra');
        $RequisitoEspejo->setNombre((string) $entity);
        $this->em->persist($RequisitoEspejo);
        
        $entity->setRequisitoEspejo($RequisitoEspejo);
    }
}

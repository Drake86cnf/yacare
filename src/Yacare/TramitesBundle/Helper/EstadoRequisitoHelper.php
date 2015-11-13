<?php
namespace Yacare\TramitesBundle\Helper;

use Doctrine\ORM\Event\LifecycleEventArgs;

/**
 * Maneja los eventos "lyfecycle" para actuar ante ciertos cambios en los estados de los requisitos de un trámite.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class EstadoRequisitoHelper extends \Yacare\BaseBundle\Helper\Helper
{

    function __construct($em = null)
    {
        parent::__construct($em);
    }

    public function PreUpdatePersist($entity, $args = null)
    {
        if($this->EsActualizacion && $args->hasChangedField('Estado')) {
            if ($entity->getEstado() == 100) {
                // Al cambiar el estado por "aprobado", marco la fecha en la que fue aprobado
                $entity->setFechaAprobado(new \DateTime());
            }
        }
        
        if ($entity->getEstado() > 0 && $entity->getTramite()->getEstado() == 0) {
            // Doy el trámite por iniciado
            $entity->getTramite()->setEstado(10);
            $this->em->persist($entity->getTramite());
        }
    }
}

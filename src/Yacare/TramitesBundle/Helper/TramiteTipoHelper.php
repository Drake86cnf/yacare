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
    function __construct($listener = null, $em = null)
    {
        parent::__construct($listener, $em);
    }
    
    public function PreUpdatePersist($entity, $args = null) {
        // Crear o actualizar un requisito asociado
        $RequisitoEspejo = $entity->getRequisitoEspejo();
        if (! $RequisitoEspejo) {
            $RequisitoEspejo = new \Yacare\TramitesBundle\Entity\Requisito();
            $RequisitoEspejo->setTramiteTipoEspejo($entity);
        }
        
        if($entity->getEtapas()) {
            $Etapas = explode(',', $entity->getEtapas());
            $NuevasEtapas = [];
            foreach($Etapas as $Etapa) {
                $Etapa = trim($Etapa);
                if($Etapa) {
                    $NuevasEtapas[] = $Etapa;
                }
            }
            $entity->setEtapas(join(',', $NuevasEtapas));
        }
        
        $RequisitoEspejo->setTipo('tra');
        $RequisitoEspejo->setNombre((string) $entity);
        $this->em->persist($RequisitoEspejo);
        
        $entity->setRequisitoEspejo($RequisitoEspejo);
    }
}

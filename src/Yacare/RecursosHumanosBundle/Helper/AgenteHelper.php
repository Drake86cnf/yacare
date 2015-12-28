<?php
namespace Yacare\RecursosHumanosBundle\Helper;

use Doctrine\ORM\Event\LifecycleEventArgs;

/**
 * Maneja los eventos "lyfecycle" para actuar ante ciertos cambios en los agentes.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class AgenteHelper extends \Yacare\BaseBundle\Helper\Helper
{

    function __construct($listener = null, $em = null)
    {
        parent::__construct($listener, $em);
    }

    public function PreUpdatePersist($entity, $args = null)
    {
        $Persona = $entity->getPersona();
        $GrupoAgentes = $this->em->getRepository('YacareBaseBundle:PersonaGrupo')->find(1);
        
        // Si no está en el grupo agentes, lo agrego
        if ($Persona->getGrupos()->contains($GrupoAgentes) == false) {
            //$this->GrupoAgentes->getPersonas()->add($Persona);
            $Persona->getGrupos()->add($GrupoAgentes);
            $this->em->persist($Persona);
            
            // Le pongo el número de legajo en la persona
            if ($entity->getId()) {
                $Persona->setAgenteId($entity->getId());
            }
            
            //$this->AgregarEntidadAlConjuntoDeCambios($Persona);
        }
    }
}

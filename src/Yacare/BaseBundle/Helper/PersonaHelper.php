<?php
namespace Yacare\BaseBundle\Helper;

/**
 * Maneja los eventos "lyfecycle" para actuar ante ciertos cambios en las personas.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class PersonaHelper extends \Yacare\BaseBundle\Helper\Helper
{
    function __construct($listener = null, $em = null)
    {
        parent::__construct($listener, $em);
    }
    
    public function PreUpdatePersist($entity, $args = null) {
        $entity->setNombreVisible($entity->CalcularNombreVisible());        
    }
}

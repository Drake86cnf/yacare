<?php
namespace Tapir\BaseBundle\Entity;

/**
 * Interfaz para que los bundles que implementen la persona (usuario).
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 *
 * @see http://symfony.com/doc/current/cookbook/doctrine/resolve_target_entity.html
 */
interface PersonaInterface
{
    /**
     * @return string
     */
    public function __toString();
}

<?php
namespace Tapir\BaseBundle\Entity;

/**
 * Interfaz para que los bundles que implementen la persona (usuario).
 *
 * @see http://symfony.com/doc/current/cookbook/doctrine/resolve_target_entity.html
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
interface PersonaInterface
{
    /**
     * @return string
     */
    public function __toString();
}
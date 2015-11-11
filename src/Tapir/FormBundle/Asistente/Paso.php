<?php

namespace Tapir\FormBundle\Asistente;

/**
 * Abstract Implementation of IPaso
 *
 * @package PeytzWizard
 */
abstract class Paso implements IPaso
{
    /**
     * @return string
     */
    public function getName()
    {
        return substr(strtolower(current(array_reverse(explode('\\', get_called_class())))), 0, -4);
    }

    /**
     * @return Boolean
     */
    public function isVisible($entidad)
    {
        return true;
    }
}

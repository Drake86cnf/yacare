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
     * Processing. If a previous step have altered a report and this step depends on it
     * do the necesarry invalidation here.
     */
    public function process($entidad)
    {
    }

    /**
     * @return Boolean
     */
    public function isVisible($entidad)
    {
        return true;
    }
}

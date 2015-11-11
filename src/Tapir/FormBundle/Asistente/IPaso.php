<?php

namespace Tapir\FormBundle\Asistente;

/**
 * @package PeytzWizard
 */
interface IPaso
{
    /**
     * @return Symfony\Component\Form\FormTypeInterface
     */
    public function getFormType();

    /**
     * @return string
     */
    public function getName();

    /**
     * @param object $entidad
     * @return Boolean
     */
    public function isVisible($entidad);
}

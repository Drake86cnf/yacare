<?php

namespace Yacare\AyudaBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Bundle que remplaza partes de la ayuda de Tapir.
 * 
 * http://symfony.com/doc/current/cookbook/bundles/inheritance.html
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class YacareAyudaBundle extends Bundle
{
    public function getParent()
    {
        return 'TapirAyudaBundle';
    }
}

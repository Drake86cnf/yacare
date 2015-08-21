<?php

namespace Yacare\TemplateBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Bundle que remplaza partes de la plantilla de Tapir.
 * 
 * http://symfony.com/doc/current/cookbook/bundles/inheritance.html
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class YacareTemplateBundle extends Bundle
{
    public function getParent()
    {
        return 'TapirTemplateBundle';
    }
}

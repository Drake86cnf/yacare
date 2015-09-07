<?php
namespace Tapir\BaseBundle\Controller;

use \Tests\Tapir\PruebaFuncional;

/**
 * Prueba base para todos los controladores que derivan de BaseController.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 * @abstract
 */
abstract class BaseControllerTest extends \Tests\Tapir\PruebaFuncional
{
    protected $item;
}

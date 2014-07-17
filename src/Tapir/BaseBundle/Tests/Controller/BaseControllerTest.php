<?php

namespace Tapir\BaseBundle\Controller;

use Tapir\BaseBundle\Tests\PruebaFuncional;
use Tapir\BaseBundle\Controller\BaseController;

abstract class BaseControllerTest extends PruebaFuncional
{
    protected $item;

    public function testConstructor()
    {
        $this->assertEquals('Base', $this->item->BundleName);
        $this->assertEquals('YacareBase', $this->item->EntityName);
    }
    
    public function testBaseRoute()
    {
        $this->assertEquals('yacare_base_yacarebase', $this->item->obtenerRutaBase());
        $this->assertEquals('yacare_base_yacarebase_listar', $this->item->obtenerRutaBase('listar'));
    }
}

<?php

namespace Yacare\BaseBundle\Controller;

use Yacare\BaseBundle\Tests\PruebaFuncional;
use Yacare\BaseBundle\Controller\YacareBaseController;

abstract class YacareBaseControllerTest extends PruebaFuncional
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

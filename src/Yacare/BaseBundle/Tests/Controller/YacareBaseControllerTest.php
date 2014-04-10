<?php

namespace Yacare\BaseBundle\Controller;

use Yacare\BaseBundle\Tests\PruebaFuncional;
use Yacare\BaseBundle\Controller\YacareBaseController;

class YacareBaseControllerTest extends PruebaFuncional
{
    protected $item;

    public function setUp()
    {
        parent::setUp();

        $this->item = new YacareBaseController();
    }

    public function testConstructor()
    {
        $this->assertEquals('Base', $this->item->BundleName);
        $this->assertEquals('YacareBase', $this->item->EntityName);
    }
    
    public function testBaseRoute()
    {
        $this->assertEquals('yacare_base_yacarebase', $this->item->getBaseRoute());
        $this->assertEquals('yacare_base_yacarebase_listar', $this->item->getBaseRoute('listar'));
    }
}

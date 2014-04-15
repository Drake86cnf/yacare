<?php

namespace Yacare\SeguridadBundle\Controller;

class CamaraControllerTest extends \Yacare\BaseBundle\Tests\Controller\YacareGenericAbmControllerTest
{
    public function setUp()
    {
        parent::setUp();

        $this->item = new CamaraController();
    }
}

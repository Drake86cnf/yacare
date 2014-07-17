<?php

namespace Yacare\SeguridadBundle\Controller;

class CamaraControllerTest extends \Tapir\BaseBundle\Tests\Controller\GenericAbmControllerTest
{
    public function setUp()
    {
        parent::setUp();

        $this->item = new CamaraController();
    }
}

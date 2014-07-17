<?php

namespace Yacare\TramitesBundle\Controller;

class RequisitoControllerTest extends \Tapir\BaseBundle\Tests\Controller\GenericAbmControllerTest
{
    public function setUp()
    {
        parent::setUp();

        $this->item = new RequisitoController();
    }
}

<?php

namespace Yacare\TramitesBundle\Controller;

class InstrumentoControllerTest extends \Tapir\BaseBundle\Tests\Controller\GenericAbmControllerTest
{
    public function setUp()
    {
        parent::setUp();

        $this->item = new InstrumentoController();
    }
}

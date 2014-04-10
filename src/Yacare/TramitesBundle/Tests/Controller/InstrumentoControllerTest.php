<?php

namespace Yacare\TramitesBundle\Controller;

class InstrumentoControllerTest extends \Yacare\BaseBundle\Tests\Controller\YacareGenericAbmControllerTest
{
    public function setUp()
    {
        parent::setUp();

        $this->item = new InstrumentoController();
    }
}

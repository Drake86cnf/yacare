<?php

namespace Yacare\TramitesBundle\Controller;

class EstadoRequisitoControllerTest extends \Yacare\BaseBundle\Tests\Controller\YacareGenericAbmControllerTest
{
    public function setUp()
    {
        parent::setUp();

        $this->item = new EstadoRequisitoController();
    }
}

<?php

namespace Yacare\ObrasParticularesBundle\Controller;

class InspeccionComercioControllerTest extends \Tapir\BaseBundle\Tests\Controller\GenericAbmControllerTest
{
    public function setUp()
    {
        parent::setUp();

        $this->item = new InspeccionComercioController();
    }
}

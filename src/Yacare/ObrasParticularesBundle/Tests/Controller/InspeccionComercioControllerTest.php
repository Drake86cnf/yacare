<?php

namespace Yacare\ObrasParticularesBundle\Controller;

class InspeccionComercioControllerTest extends \Yacare\BaseBundle\Tests\Controller\YacareGenericAbmControllerTest
{
    public function setUp()
    {
        parent::setUp();

        $this->item = new InspeccionComercioController();
    }
}

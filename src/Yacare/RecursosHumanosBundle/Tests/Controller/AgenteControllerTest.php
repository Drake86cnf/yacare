<?php

namespace Yacare\RecursosHumanosBundle\Controller;

class AgenteControllerTest extends \Yacare\BaseBundle\Tests\Controller\YacareGenericAbmControllerTest
{
    public function setUp()
    {
        parent::setUp();

        $this->item = new AgenteController();
    }
}

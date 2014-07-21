<?php

namespace Yacare\ObrasParticularesBundle\Controller;

class TramiteCatControllerTest extends \Tapir\BaseBundle\Tests\Controller\GenericAbmControllerTest
{
    public function setUp()
    {
        parent::setUp();

        $this->item = new TramiteCatController();
    }
}

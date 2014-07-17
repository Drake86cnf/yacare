<?php

namespace Yacare\TramitesBundle\Controller;

class TramiteControllerTest extends \Tapir\BaseBundle\Tests\Controller\GenericAbmControllerTest
{
    public function setUp()
    {
        parent::setUp();

        $this->item = new TramiteController();
    }
}

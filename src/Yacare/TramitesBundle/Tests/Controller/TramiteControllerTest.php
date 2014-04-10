<?php

namespace Yacare\TramitesBundle\Controller;

class TramiteControllerTest extends \Yacare\BaseBundle\Tests\Controller\YacareGenericAbmControllerTest
{
    public function setUp()
    {
        parent::setUp();

        $this->item = new TramiteController();
    }
}

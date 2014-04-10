<?php

namespace Yacare\TramitesBundle\Controller;

class RequisitoControllerTest extends \Yacare\BaseBundle\Tests\Controller\YacareGenericAbmControllerTest
{
    public function setUp()
    {
        parent::setUp();

        $this->item = new RequisitoController();
    }
}

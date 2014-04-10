<?php

namespace Yacare\TramitesBundle\Controller;

class TramiteTipoControllerTest extends \Yacare\BaseBundle\Tests\Controller\YacareGenericAbmControllerTest
{
    public function setUp()
    {
        parent::setUp();

        $this->item = new TramiteTipoController();
    }
}

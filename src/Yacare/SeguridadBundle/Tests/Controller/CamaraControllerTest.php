<?php

namespace Yacare\SeguridadBundle\Controller;

class cControllerTest extends \Yacare\BaseBundle\Tests\Controller\YacareGenericAbmControllerTest
{
    public function setUp()
    {
        parent::setUp();

        $this->item = new CamaraController();
    }
}

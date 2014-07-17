<?php

namespace Tapir\BaseBundle\Controller;

use Yacare\BaseBundle\Tests\YacareWebTestCase;
use Symfony\Component\HttpFoundation\Response;

class UsuarioControllerTest extends \Tapir\BaseBundle\Tests\Controller\GenericAbmControllerTest
{
    public function setUp()
    {
        parent::setUp();

        $this->item = new UsuarioController();
    }
}

<?php

namespace Yacare\BaseBundle\Controller;

use Yacare\BaseBundle\Tests\YacareWebTestCase;
use Symfony\Component\HttpFoundation\Response;

class PersonaControllerTest extends \Yacare\BaseBundle\Tests\Controller\YacareGenericAbmControllerTest
{
    public function setUp()
    {
        parent::setUp();

        $this->item = new PersonaController();
    }
}

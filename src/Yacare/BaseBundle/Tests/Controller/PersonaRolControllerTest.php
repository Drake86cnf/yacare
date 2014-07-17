<?php

namespace Yacare\BaseBundle\Controller;

use Yacare\BaseBundle\Tests\YacareWebTestCase;
use Symfony\Component\HttpFoundation\Response;

class PersonaRolControllerTest extends \Tapir\BaseBundle\Tests\Controller\GenericAbmControllerTest
{
    public function setUp()
    {
        parent::setUp();

        $this->item = new PersonaRolController();
    }
}

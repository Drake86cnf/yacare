<?php

namespace Yacare\BaseBundle\Controller;

use Yacare\BaseBundle\Tests\YacareWebTestCase;
use Symfony\Component\HttpFoundation\Response;

class PersonaGrupoControllerTest extends \Yacare\BaseBundle\Tests\Controller\YacareGenericAbmControllerTest
{
    public function setUp()
    {
        parent::setUp();

        $this->item = new PersonaGrupoController();
    }
}

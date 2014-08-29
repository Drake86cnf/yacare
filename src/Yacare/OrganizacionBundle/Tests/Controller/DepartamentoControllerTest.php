<?php
namespace Yacare\OrganizacionBundle\Controller;

use Yacare\BaseBundle\Tests\YacareWebTestCase;
use Symfony\Component\HttpFoundation\Response;

class DepartamentoControllerTest extends \Tapir\BaseBundle\Tests\Controller\GenericAbmControllerTest
{

    public function setUp()
    {
        parent::setUp();
        
        $this->item = new DepartamentoController();
    }
}

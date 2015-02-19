<?php
namespace Yacare\BaseBundle\Controller;

use Yacare\BaseBundle\Tests\YacareWebTestCase;
use Symfony\Component\HttpFoundation\Response;

class DispositivoGenericoControllerTest extends \Tapir\BaseBundle\Controller\AbmControllerTest
{

    public function setUp()
    {
        parent::setUp();
        
        $this->item = new DispositivoGenericoController();
    }
}

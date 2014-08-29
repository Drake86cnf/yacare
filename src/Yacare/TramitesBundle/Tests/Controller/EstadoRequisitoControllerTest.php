<?php
namespace Yacare\TramitesBundle\Controller;

class EstadoRequisitoControllerTest extends \Tapir\BaseBundle\Tests\Controller\GenericAbmControllerTest
{

    public function setUp()
    {
        parent::setUp();
        
        $this->item = new EstadoRequisitoController();
    }
}

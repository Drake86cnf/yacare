<?php
namespace Yacare\TramitesBundle\Controller;

class EstadoRequisitoControllerTest extends \Tapir\BaseBundle\Controller\AbmControllerTest
{

    public function setUp()
    {
        parent::setUp();
        
        $this->item = new EstadoRequisitoController();
    }
}

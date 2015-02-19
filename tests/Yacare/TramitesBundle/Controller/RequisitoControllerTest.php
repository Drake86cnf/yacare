<?php
namespace Yacare\TramitesBundle\Controller;

class RequisitoControllerTest extends \Tapir\BaseBundle\Controller\AbmControllerTest
{

    public function setUp()
    {
        parent::setUp();
        
        $this->item = new RequisitoController();
    }
}

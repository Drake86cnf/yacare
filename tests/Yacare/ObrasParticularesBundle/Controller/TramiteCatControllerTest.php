<?php
namespace Yacare\ObrasParticularesBundle\Controller;

class TramiteCatControllerTest extends \Tapir\BaseBundle\Controller\AbmControllerTest
{

    public function setUp()
    {
        parent::setUp();
        
        $this->item = new TramiteCatController();
    }
}

<?php
namespace Yacare\TramitesBundle\Controller;

class TramiteControllerTest extends \Tapir\BaseBundle\Controller\AbmControllerTest
{

    public function setUp()
    {
        parent::setUp();
        
        $this->item = new TramiteController();
    }
}

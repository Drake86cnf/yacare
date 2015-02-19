<?php
namespace Yacare\TramitesBundle\Controller;

class TramiteTipoControllerTest extends \Tapir\BaseBundle\Controller\AbmControllerTest
{

    public function setUp()
    {
        parent::setUp();
        
        $this->item = new TramiteTipoController();
    }
}

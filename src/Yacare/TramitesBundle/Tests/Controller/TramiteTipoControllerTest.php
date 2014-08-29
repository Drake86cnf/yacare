<?php
namespace Yacare\TramitesBundle\Controller;

class TramiteTipoControllerTest extends \Tapir\BaseBundle\Tests\Controller\GenericAbmControllerTest
{

    public function setUp()
    {
        parent::setUp();
        
        $this->item = new TramiteTipoController();
    }
}

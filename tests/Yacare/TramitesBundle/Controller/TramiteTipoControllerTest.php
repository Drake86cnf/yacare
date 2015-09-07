<?php
namespace Yacare\TramitesBundle\Controller;

/**
 * Prueba para el controlador de TramiteTipo.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 * 
 * @see \Yacare\TramitesBundle\Controller\TramiteTipoController TramiteTipoController
 */
class TramiteTipoControllerTest extends \Tapir\BaseBundle\Controller\AbmControllerTest
{
    public function setUp()
    {
        parent::setUp();
        
        $this->item = new TramiteTipoController();
    }
}

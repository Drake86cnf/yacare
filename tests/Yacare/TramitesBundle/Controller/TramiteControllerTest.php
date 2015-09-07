<?php
namespace Yacare\TramitesBundle\Controller;

/**
 * Prueba para el controlador de Tramite.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 * 
 * @see \Yacare\TramiteBundle\Controller\TramiteController TramiteController
 */
class TramiteControllerTest extends \Tapir\BaseBundle\Controller\AbmControllerTest
{
    public function setUp()
    {
        parent::setUp();
        
        $this->item = new TramiteController();
    }
}

<?php
namespace Yacare\TramitesBundle\Controller;

/**
 * Prueba para el controlador de Instrumento.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 * 
 * @see \Yacare\TramitesBundle\Controller\InstrumentoController InstrumentoController
 */
class InstrumentoControllerTest extends \Tapir\BaseBundle\Controller\AbmControllerTest
{
    public function setUp()
    {
        parent::setUp();
        
        $this->item = new InstrumentoController();
    }
}

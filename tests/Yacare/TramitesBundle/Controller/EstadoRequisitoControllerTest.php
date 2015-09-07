<?php
namespace Yacare\TramitesBundle\Controller;

/**
 * Prueba para el controlador de EstadoRequisito.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 * 
 * @see \Yacare\TramitesBundle\Controller\EstadoRequisitoController EstadoRequisitoController
 */
class EstadoRequisitoControllerTest extends \Tapir\BaseBundle\Controller\AbmControllerTest
{
    public function setUp()
    {
        parent::setUp();
        
        $this->item = new EstadoRequisitoController();
    }
}

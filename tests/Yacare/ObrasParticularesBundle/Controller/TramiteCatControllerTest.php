<?php
namespace Yacare\ObrasParticularesBundle\Controller;

/**
 * Prueba para el controlador de TramiteCat.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 * 
 * @see \Yacare\ObrasParticulares\Controller\TramiteCatController TramiteCatController
 */
class TramiteCatControllerTest extends \Tapir\BaseBundle\Controller\AbmControllerTest
{
    public function setUp()
    {
        parent::setUp();
        
        $this->item = new TramiteCatController();
    }
}

<?php
namespace Yacare\FlotaBundle\Controller;

use Symfony\Component\HttpFoundation\Response;

/**
 * Prueba para el controlador de vehículos.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 *
 * @see \Yacare\FlotaBundle\Controller\VehiculoController VehiculoController
 */
class VehiculoControllerTest extends \Tapir\AbmBundle\Controller\AbmControllerTest
{
    public function setUp()
    {
        parent::setUp();
        
        $this->item = new VehiculoController();
    }
}

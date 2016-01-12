<?php
namespace Yacare\NominaBundle\Controller;

use Symfony\Component\HttpFoundation\Response;

/**
 * Prueba para el controlador de DispositivoGenerico.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 *
 * @see \Yacare\NominaBundle\Controller\DispositivoGenericoController DispositivoGenericoController
 */
class DispositivoGenericoControllerTest extends \Tapir\AbmBundle\Controller\AbmControllerTest
{
    public function setUp()
    {
        parent::setUp();
        
        $this->item = new DispositivoGenericoController();
    }
}

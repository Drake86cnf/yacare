<?php
namespace Yacare\BaseBundle\Controller;

use Yacare\BaseBundle\Tests\YacareWebTestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * Prueba para el controlador de DispositivoGenerico.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 *
 * @see \Yacare\BaseBundle\Controller\DispositivoGenericoController DispositivoGenericoController
 */
class DispositivoGenericoControllerTest extends \Tapir\BaseBundle\Controller\AbmControllerTest
{
    public function setUp()
    {
        parent::setUp();
        
        $this->item = new DispositivoGenericoController();
    }
}

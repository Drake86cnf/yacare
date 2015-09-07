<?php
namespace Yacare\TramitesBundle\Controller;

/**
 * Prueba para el controlador de Requisito.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 * 
 * @see \Yacare\TramitesBundle\Controller\RequisitoController RequisitoController
 */
class RequisitoControllerTest extends \Tapir\BaseBundle\Controller\AbmControllerTest
{
    public function setUp()
    {
        parent::setUp();
        
        $this->item = new RequisitoController();
    }
}

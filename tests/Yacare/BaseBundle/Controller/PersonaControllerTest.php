<?php
namespace Yacare\BaseBundle\Controller;

use Symfony\Component\HttpFoundation\Response;

/**
 * Prueba para controlador de Persona.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 * 
 * @see \Yacare\BaseBundle\Controller\PersonaController PersonaController
 */
class PersonaControllerTest extends \Tapir\BaseBundle\Controller\AbmControllerTest
{
    public function setUp()
    {
        parent::setUp();
        
        $this->item = new PersonaController();
    }
}

<?php
namespace Yacare\BaseBundle\Controller;

use Yacare\BaseBundle\Tests\YacareWebTestCase;
use Symfony\Component\HttpFoundation\Response;

/*
 * Prueba de PersonaController.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class PersonaControllerTest extends \Tapir\BaseBundle\Controller\AbmControllerTest
{
    public function setUp()
    {
        parent::setUp();
        
        $this->item = new PersonaController();
    }
}

<?php
namespace Yacare\OrganizacionBundle\Controller;

use Symfony\Component\HttpFoundation\Response;

/**
 * Prueba para el controlador de Departamento.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 * 
 * @see \Yacare\OrganizacionBundle\Controller\DepartamentoController DepartamentoController
 */
class DepartamentoControllerTest extends \Tapir\BaseBundle\Controller\AbmControllerTest
{
    public function setUp()
    {
        parent::setUp();
        
        $this->item = new DepartamentoController();
    }
}

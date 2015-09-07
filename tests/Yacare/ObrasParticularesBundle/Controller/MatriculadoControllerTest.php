<?php
namespace Yacare\ObrasParticularesBundle\Controller;

use Symfony\Component\HttpFoundation\Response;

/**
 * Prueba para el controlador de Matriculado.
 * 
 * @author Ezequiel Riquelme <rezequiel.tdf@gmail.com>
 * 
 * @see \Yacare\ObrasParticulares\Controller\MatriculadoController MatriculadoController
 */
class MatriculadoControllerTest extends \Tapir\BaseBundle\Controller\AbmControllerTest
{
    public function setup()
    {
        parent::setup();
        $this->item = new MatriculadoController();
    }

    public function testConstructor()
    {
        $this->assertEquals('Yacare', $this->item->getVendorName());
        $this->assertEquals('ObrasParticulares', $this->item->getBundleName());
        $this->assertEquals('Matriculado', $this->item->getEntityName());
    }

    public function testBaseRoute()
    {
        $this->assertEquals('yacare_obrasparticulares_matriculado', $this->item->obtenerRutaBase());
        $this->assertEquals('yacare_obrasparticulares_matriculado_listar', $this->item->obtenerRutaBase('listar'));
    }
}

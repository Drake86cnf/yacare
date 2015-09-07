<?php
namespace Yacare\ComercioBundle\Controller;

use Symfony\Component\HttpFoundation\Response;

/**
 * Prueba para el controlador de Comercio.
 * 
 * @author Ezequiel Riquelme <rezequiel.tdf@gmail.com>
 * 
 * @see \Yacare\ComercioBundle\Controller\ComercioController ComercioController
 */
class ComercioControllerTest extends \Tapir\BaseBundle\Controller\AbmControllerTest
{
    public function setup()
    {
        parent::setup();
        $this->item = new ComercioController();
    }

    public function testConstructor()
    {
        $this->assertEquals('Yacare', $this->item->getVendorName());
        $this->assertEquals('Comercio', $this->item->getBundlename());
        $this->assertEquals('Comercio', $this->item->getEntityName());
    }

    public function testBaseRoute()
    {
        $this->assertEquals('yacare_comercio_comercio', $this->item->obtenerRutaBase());
        $this->assertEquals('yacare_comercio_comercio_listar', $this->item->obtenerRutaBase('listar'));
    }
}

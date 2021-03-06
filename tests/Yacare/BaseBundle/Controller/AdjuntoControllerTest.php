<?php
namespace Yacare\BaseBundle\Controller;

use Symfony\Component\HttpFoundation\Response;

/**
 * Prueba para el controlador de Adjunto.
 * 
 * @author Ezequiel Riquelme <rezequiel.tdf@gmail.com>
 * 
 * @see \Yacare\BaseBundle\Controller\AdjuntoController AdjuntoController
 */
class AdjuntoControllerTest extends \Tapir\BaseBundle\Controller\BaseControllerTest
{
    public function setup()
    {
        parent::setup();
        
        $this->item = new AdjuntoController();
    }

    public function testConstructor()
    {
        $this->assertEquals('Yacare', $this->item->getVendorName());
        $this->assertEquals('Base', $this->item->getBundleName());
        $this->assertEquals('Adjunto', $this->item->getEntityName());
    }

    public function testBaseRoute()
    {
        $this->assertEquals('yacare_base_adjunto', $this->item->obtenerRutaBase());
        $this->assertEquals('yacare_base_adjunto_listar', $this->item->obtenerRutaBase('listar'));
    }
}

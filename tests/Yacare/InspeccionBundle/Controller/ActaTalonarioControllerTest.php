<?php
namespace Yacare\InspeccionBundle\Controller;

use Symfony\Component\HttpFoundation\Response;

/**
 * Prueba para el controlador de ActaTalonario.
 * 
 * @author Ezequiel Riquelme <rezequiel.tdf@gmail.com>
 * 
 * @see \Yacare\InspeccionBundle\Controller\ActaTalonarioController ActaTalonarioController
 */
class ActaTalonarioControllerTest extends \Tapir\BaseBundle\Controller\AbmControllerTest
{
    public function setup()
    {
        parent::setup();
        $this->item = new ActaTalonarioController();
    }

    public function testConstructor()
    {
        $this->assertEquals('Yacare', $this->item->getVendorName());
        $this->assertEquals('Inspeccion', $this->item->getBundleName());
        $this->assertEquals('ActaTalonario', $this->item->getEntityName());
    }

    public function testBaseRoute()
    {
        $this->assertEquals('yacare_inspeccion_actatalonario', $this->item->obtenerRutaBase());
        $this->assertEquals('yacare_inspeccion_actatalonario_listar', $this->item->obtenerRutaBase('listar'));
    }
}

<?php
namespace Yacare\InspeccionBundle\Controller;

use Symfony\Component\HttpFoundation\Response;

/**
 * Prueba para el controlador de RelevamientoResultado.
 * 
 * @author Ezequiel Riquelme <rezequiel.tdf@gmail.com>
 * 
 * @see \Yacare\InspeccionBundle\Controller\RelevamientoResultadoController RelevamientoResultadoController
 */
class RelevamientoResultadoControllerTest extends \Tapir\BaseBundle\Controller\AbmControllerTest
{
    public function setup()
    {
        parent::setup();
        $this->item = new RelevamientoResultadoController();
    }

    public function testConstructor()
    {
        $this->assertEquals('Yacare', $this->item->getVendorName());
        $this->assertEquals('Inspeccion', $this->item->getBundleName());
        $this->assertEquals('RelevamientoResultado', $this->item->getEntityName());
    }

    public function testBaseRoute()
    {
        $this->assertEquals('yacare_inspeccion_relevamientoresultado', $this->item->obtenerRutaBase());
        $this->assertEquals('yacare_inspeccion_relevamientoresultado_listar', $this->item->obtenerRutaBase('listar'));
    }
}

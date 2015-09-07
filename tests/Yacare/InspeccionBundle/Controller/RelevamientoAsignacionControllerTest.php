<?php
namespace Yacare\InspeccionBundle\Controller;

use Symfony\Component\HttpFoundation\Response;

/**
 * Prueba para el controlador de RelevamientoAsignacion.
 * 
 * @author Ezequiel Riquelme <rezequiel.tdf@gmail.com>
 * 
 * @see \Yacare\InspeccionBundle\Controller\RelevamientoAsignacionController RelevamientoAsignacionController
 */
class RelevamientoAsignacionControllerTest extends \Tapir\BaseBundle\Controller\AbmControllerTest
{
    public function setup()
    {
        parent::setup();
        $this->item = new RelevamientoAsignacionController();
    }

    public function testConstructor()
    {
        $this->assertEquals('Yacare', $this->item->getVendorName());
        $this->assertEquals('Inspeccion', $this->item->getBundleName());
        $this->assertEquals('RelevamientoAsignacion', $this->item->getEntityName());
    }

    public function testBaseRoute()
    {
        $this->assertEquals('yacare_inspeccion_relevamientoasignacion', $this->item->obtenerRutaBase());
        $this->assertEquals('yacare_inspeccion_relevamientoasignacion_listar', $this->item->obtenerRutaBase('listar'));
    }
}

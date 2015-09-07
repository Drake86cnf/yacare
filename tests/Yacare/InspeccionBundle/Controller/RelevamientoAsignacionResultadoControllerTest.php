<?php
namespace Yacare\InspeccionBundle\Controller;

use Symfony\Component\HttpFoundation\Response;

/**
 * Prueba para el controlador RelevamientoAsignacionResultado.
 * 
 * @author Ezequiel Riquelme <rezequiel.tdf@gmail.com>
 * 
 * @see \Yacare\InspeccionBundle\Controller\RelevamientoAsignacionResultadoController RelevamientoAsignacionResultadoController
 */
class RelevamientoAsignacionResultadoControllerTest extends \Tapir\BaseBundle\Controller\AbmControllerTest
{
    public function setup()
    {
        parent::setup();
        $this->item = new RelevamientoAsignacionResultadoController();
    }

    public function testConstructor()
    {
        $this->assertEquals('Yacare', $this->item->getVendorName());
        $this->assertEquals('Inspeccion', $this->item->getBundleName());
        $this->assertEquals('RelevamientoAsignacionResultado', $this->item->getEntityName());
    }

    public function testBaseRoute()
    {
        $this->assertEquals('yacare_inspeccion_relevamientoasignacionresultado', $this->item->obtenerRutaBase());
        $this->assertEquals('yacare_inspeccion_relevamientoasignacionresultado_listar', 
            $this->item->obtenerRutaBase('listar'));
    }
}

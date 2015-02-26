<?php
namespace Yacare\InspeccionBundle\Controller;

use Symfony\Component\HttpFoundation\Response;

/*
 * Prueba de RelevamientoAsignacionDetalleController.
 * 
 * @author Ezequiel Riquelme <rezequiel.tdf@gmail.com>
 */

class RelevamientoAsignacionDetalleControllerTest extends \Tapir\BaseBundle\Controller\AbmControllerTest
{
	public function setup()
	{
		parent::setup();
		$this->item = new RelevamientoAsignacionDetalleController();
	}
	
	public function testConstructor()
	{
		$this->assertEquals('Yacare', $this->item->getVendorName());
		$this->assertEquals('Inspeccion', $this->item->getBundleName());
		$this->assertEquals('RelevamientoAsignacionDetalle', $this->item->getEntityName());
	}
	
	public function testBaseRoute()
	{
		$this->assertEquals('yacare_inspeccion_relevamientoasignaciondetalle', $this->item->obtenerRutaBase());
		$this->assertEquals('yacare_inspeccion_relevamientoasignaciondetalle_listar', $this->item->obtenerRutaBase('listar'));
	}
}
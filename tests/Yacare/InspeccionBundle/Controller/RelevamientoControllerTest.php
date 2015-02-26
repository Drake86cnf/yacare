<?php
namespace Yacare\InspeccionBundle\Controller;

use Symfony\Component\HttpFoundation\Response;

/*
 * Prueba de RelevamientoController.
 * 
 * @author Ezequiel Riquelme <rezequiel.tdf@gmail.com>
 */

class RelevamientoControllerTest extends \Tapir\BaseBundle\Controller\AbmControllerTest
{
	public function setup()
	{
		parent::setup();
		$this->item = new RelevamientoController();
	}
	
	public function testConstructor()
	{
		$this->assertEquals('Yacare', $this->item->getVendorName());
		$this->assertEquals('Inspeccion', $this->item->getBundleName());
		$this->assertEquals('Relevamiento', $this->item->getEntityName());
	}
	
	public function testBaseRoute()
	{
		$this->assertEquals('yacare_inspeccion_relevamiento', $this->item->obtenerRutaBase());
		$this->assertEquals('yacare_inspeccion_relevamiento_listar', $this->item->obtenerRutaBase('listar'));
	}
}
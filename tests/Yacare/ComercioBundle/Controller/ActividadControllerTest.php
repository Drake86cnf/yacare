<?php
namespace Yacare\ComercioBundle\Controller;

use Symfony\Component\HttpFoundation\Response;

/*
 * Prueba de ActividadController.
 * 
 * @author Ezequiel Riquelme <rezequiel.tdf@gmail.com>
 */

class ActividadControllerTest extends \Tapir\BaseBundle\Controller\AbmControllerTest
{
	public function setup()
	{
		parent::setup();
		$this->item = new ActividadController();
	}
	
	public function testConstructor()
	{
		$this->assertEquals('Yacare', $this->item->getVendorName());
		$this->assertEquals('Comercio', $this->item->getBundleName());
		$this->assertEquals('Actividad', $this->item->getEntityName());
	}
	
	public function testBaseRoute()
	{
		$this->assertEquals('yacare_comercio_actividad', $this->item->obtenerRutaBase());
		$this->assertEquals('yacare_comercio_actividad_listar', $this->item->obtenerRutaBase('listar'));
	}
}
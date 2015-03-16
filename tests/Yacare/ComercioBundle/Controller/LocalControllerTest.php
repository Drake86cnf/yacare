<?php
namespace Yacare\ComercioBundle\Controller;

use Symfony\Component\HttpFoundation\Response;

/**
 * Prueba de LocalController.
 * 
 * @author Ezequiel Riquelme <rezequiel.tdf@gmail.com>
 */

class LocalControllerTest extends \Tapir\BaseBundle\Controller\AbmControllerTest
{
	public function setup()
	{
		parent::setup();
		$this->item = new LocalController();
	}
	
	public function testConstructor()
	{
		$this->assertEquals('Yacare', $this->item->getVendorName());
		$this->assertEquals('Comercio', $this->item->getBundleName());
		$this->assertEquals('Local', $this->item->getEntityName());
	}
	
	public function testBaseRoute()
	{
		$this->assertEquals('yacare_comercio_local', $this->item->obtenerRutaBase());
		$this->assertEquals('yacare_comercio_local_listar', $this->item->obtenerRutaBase('listar'));
	}
}
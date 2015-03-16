<?php
namespace Yacare\BaseBundle\Controller;

use Symfony\Component\HttpFoundation\Response;

/**
 * Prueba de DispositivoRastreadorGpsController.
 * 
 * @author Ezequiel Riquelme <rezequiel.tdf@gmail.com>
 */

class DispositivoRastreadorGpsControllerTest extends \Tapir\BaseBundle\Controller\AbmControllerTest
{
	public function setup()
	{
		parent::setup();
		$this -> item = new DispositivoRastreadorGpsController();
	}
	
	public function testConstructor()
	{
		$this->assertEquals('Yacare', $this->item->getVendorName());
		$this->assertEquals('Base', $this->item->getBundleName());
		$this->assertEquals('DispositivoRastreadorGps', $this->item->getEntityName());
	}
	
	public function testBaseRoute()
	{
		$this->assertEquals('yacare_base_dispositivorastreadorgps', $this->item->obtenerRutaBase());
		$this->assertEquals('yacare_base_dispositivorastreadorgps_listar', $this->item->obtenerRutaBase('listar'));	
	}
}
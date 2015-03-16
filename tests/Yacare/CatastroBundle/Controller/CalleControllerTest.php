<?php
namespace Yacare\CatastroBundle\Controller;

use Symfony\Component\HttpFoundation\Response;

/**
 * Prueba de CalleController.
 * 
 * @author Ezequiel Riquelme <rezequiel.tdf@gmail.com>
 */

class CalleControllerTest extends \Tapir\BaseBundle\Controller\AbmControllerTest
{
	public function setup()
	{
		parent::setup();
		$this->item = new CalleController();
	}
	
	public function testConstructor()
	{
		$this->assertEquals('Yacare', $this->item->getVendorName());
		$this->assertEquals('Catastro', $this->item->getBundleName());
		$this->assertEquals('Calle', $this->item->getEntityName());
	}
	
	public function testBaseRoute()
	{
		$this->assertEquals('yacare_catastro_calle', $this->item->obtenerRutaBase());
		$this->assertEquals('yacare_catastro_calle_listar', $this->item->obtenerRutaBase('listar'));
	}
}
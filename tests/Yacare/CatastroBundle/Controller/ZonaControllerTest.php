<?php
namespace Yacare\CatastroBundle\Controller;

use Symfony\Component\HttpFoundation\Response;

/*
 * Prueba de ZonaController.
 * 
 * @author Ezequiel Riquelme <rezequiel.tdf@gmail.com>
 */

class ZonaControllerTest extends \Tapir\BaseBundle\Controller\AbmControllerTest
{
	public function setUp()
	{
		parent::setup();
		$this->item = new ZonaController();
	}
	
	public function testConstructor()
	{
		$this->assertEquals('Yacare', $this->item->getVendorName());
		$this->assertEquals('Catastro', $this->item->getBundleName());
		$this->assertEquals('Zona', $this->item->getEntityName());
	}
	
	public function testBaseRoute()
	{
		$this->assertEquals('yacare_catastro_zona', $this->item->obtenerRutaBase());
		$this->assertEquals('yacare_catastro_zona_listar', $this->item->obtenerRutaBase('listar'));
	}
}
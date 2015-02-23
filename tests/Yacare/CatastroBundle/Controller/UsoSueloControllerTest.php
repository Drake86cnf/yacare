<?php
namespace Yacare\CatastroBundle\Controller;

use Symfony\Component\HttpFoundation\Response;

/*
 * Prueba de UsoSueloController.
 * 
 * @author Ezequiel Riquelme <rezequiel.tdf@gmail.com>
 */

class UsoSueloControllerTest extends \Tapir\BaseBundle\Controller\AbmControllerTest
{
	public function setup()
	{
		parent::setup();
		$this->item = new UsoSueloController();
	}
	
	public function testConstructor()
	{
		$this->assertEquals('Yacare', $this->item->getVendorName());
		$this->assertEquals('Catastro', $this->item->getBundleName());
		$this->assertEquals('UsoSuelo', $this->item->getEntityName());
	}
	
	public function testBaseRoute()
	{
		$this->assertEquals('yacare_catastro_usosuelo', $this->item->obtenerRutaBase());
		$this->assertEquals('yacare_catastro_usosuelo_listar', $this->item->obtenerRutaBase('listar'));
	}
}
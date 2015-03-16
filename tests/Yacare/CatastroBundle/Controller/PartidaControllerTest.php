<?php
namespace Yacare\CatastroBundle\Controller;

use Symfony\Component\HttpFoundation\Response;

/**
 * Prueba de PartidaController.
 * 
 * @author Ezequiel Riquelme <rezequiel.tdf@gmail.com>
 */

class PartidaControllerTest extends \Tapir\BaseBundle\Controller\AbmControllerTest
{
	public function setup()
	{
		parent::setup();
		$this->item = new PartidaController();
	}
	
	public function testConstructor()
	{
		$this->assertEquals('Yacare', $this->item->getVendorName());
		$this->assertEquals('Catastro', $this->item->getBundleName());
		$this->assertEquals('Partida', $this->item->getEntityName());
	}
	
	public function testBaseRoute()
	{
		$this->assertEquals('yacare_catastro_partida', $this->item->obtenerRutaBase());
		$this->assertEquals('yacare_catastro_partida_listar', $this->item->obtenerRutaBase('listar'));
	}
}
<?php
namespace Yacare\ObrasParticularesBundle\Controller;

use Symfony\Component\HttpFoundation\Response;

/*
 * Prueba de ActaController.
 * 
 * @author Ezequiel Riquelme <rezequiel.tdf@gmail.com>
 */

class ActaControllerTest extends \Tapir\BaseBundle\Controller\AbmControllerTest
{
	public function setup()
	{
		parent::setup();
		$this->item = new ActaController();
	}
	
	public function testConstructor()
	{
		$this->assertEquals('Yacare', $this->item->getVendorName());
		$this->assertEquals('ObrasParticulares', $this->item->getBundleName());
		$this->assertEquals('Acta', $this->item->getEntityName());
	}
	
	public function testBaseRoute()
	{
		$this->assertEquals('yacare_obrasparticulares_acta', $this->item->obtenerRutaBase());
		$this->assertEquals('yacare_obrasparticulares_acta_listar', $this->item->obtenerRutaBase('listar'));
	}
}
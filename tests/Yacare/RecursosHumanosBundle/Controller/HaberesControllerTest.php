<?php
namespace Yacare\RecursosHumanosBundle\Controller;

use Symfony\Component\HttpFoundation\Response;

/*
 * Prueba de HaberesController.
 * 
 * @author Ezequiel Riquelme <rezequiel.tdf@gmail.com>
 */

class HaberesControllerTest extends \Tapir\BaseBundle\Controller\BaseControllerTest
{
	public function setup()
	{
		parent::setup();
		$this->item = new HaberesController();
	}
	
	public function testConstructor()
	{
		$this->assertEquals('Yacare', $this->item->getVendorName());
		$this->assertEquals('RecursosHumanos', $this->item->getBundleName());
		$this->assertEquals('Haberes', $this->item->getEntityName());
	}
	
	public function testBaseRoute()
	{
		$this->assertEquals('yacare_recursoshumanos_haberes', $this->item->obtenerRutaBase());
		$this->assertEquals('yacare_recursoshumanos_haberes_listar', $this->item->obtenerRutaBase('listar'));
	}
}
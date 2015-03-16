<?php
namespace Yacare\BaseBundle\Controller;

use Symfony\Component\HttpFoundation\Response;

/**
 * Prueba de ComentarioController.
 * 
 * @author Ezequiel Riquelme <rezequiel.tdf@gmail.com>
 */

class ComentarioControllerTest extends \Tapir\BaseBundle\Controller\AbmControllerTest
{
	public function setup()
	{
		parent::setup();
		$this -> item = new ComentarioController();
	}
	
	public function testConstructor()
	{
		$this->assertEquals('Yacare', $this->item->getVendorName());
		$this->assertEquals('Base', $this->item->getBundleName());
		$this->assertEquals('Comentario', $this->item->getEntityName());
	}
	
	public function testBaseRoute()
	{
		$this->assertEquals('yacare_base_comentario',$this->item->obtenerRutaBase());
		$this->assertEquals('yacare_base_comentario_listar', $this->item->obtenerRutaBase('listar'));
	}
}
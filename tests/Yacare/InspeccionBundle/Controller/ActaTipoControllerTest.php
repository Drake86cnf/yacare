<?php
namespace Yacare\InspeccionBundle\Controller;

use Symfony\Component\HttpFoundation\Response;

/*
 * Prueba de ActaTipoController.
 * 
 * @author Ezequiel Riquelme <rezequiel.tdf@gmail.com>
 */

class ActaTipoControllerTest extends \Tapir\BaseBundle\Controller\AbmControllerTest
{
	public function setup()
	{
		parent::setup();
		$this->item = new ActaTipoController();
	}
	
	public function testConstructor()
	{
		$this->assertEquals('Yacare', $this->item->getVendorName());
		$this->assertEquals('Inspeccion', $this->item->getBundleName());
		$this->assertEquals('ActaTipo', $this->item->getEntityName());
	}
	
	public function testBaseRoute()
	{
		$this->assertEquals('yacare_inspeccion_actatipo', $this->item->obtenerRutaBase());
		$this->assertEquals('yacare_inspeccion_actatipo_listar', $this->item->obtenerRutaBase('listar'));
	}
}
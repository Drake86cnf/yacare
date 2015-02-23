<?php
namespace Yacare\TramitesBundle\Controller;

use Symfony\Component\HttpFoundation\Response;

/*
 * Prueba de ComprobanteController.
 * 
 * @author Ezequiel Riquelme <rezequiel.tdf@gmail.com>
 */

class ComprobanteControllerTest extends \Tapir\BaseBundle\Controller\AbmControllerTest
{
	public function setup()
	{
		parent::setup();
		$this->item = new ComprobanteController();
	}
	
	public function testConstructor()
	{
		$this->assertEquals('Yacare', $this->item->getVendorName());
		$this->assertEquals('Tramites', $this->item->getBundleName());
		$this->assertEquals('Comprobante', $this->item->getEntityName());
	}
	
	public function testBaseRoute()
	{
		$this->assertEquals('yacare_tramites_comprobante', $this->item->obtenerRutaBase());
		$this->assertEquals('yacare_tramites_comprobante_listar', $this->item->obtenerRutaBase('listar'));
	}
}
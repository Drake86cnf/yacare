<?php
namespace Yacare\TramitesBundle\Controller;

use Symfony\Component\HttpFoundation\Response;

/**
 * Prueba para el controlador de AsociacionRequisito.
 * 
 * @author Ezequiel Riquelme <rezequiel.tdf@gmail.com>
 * 
 * @see \Yacare\TramitesBundle\Controller\AsociacionRequisitoController AsociacionRequisitoController
 */
class AsociacionRequisitoControllerTest extends \Tapir\BaseBundle\Controller\AbmControllerTest
{
    public function setup()
    {
        parent::setup();
        $this->item = new AsociacionRequisitoController();
    }

    public function testConstructor()
    {
        $this->assertEquals('Yacare', $this->item->getVendorName());
        $this->assertEquals('Tramites', $this->item->getBundleName());
        $this->assertEquals('AsociacionRequisito', $this->item->getEntityName());
    }

    public function testBaseRoute()
    {
        $this->assertEquals('yacare_tramites_asociacionrequisito', $this->item->obtenerRutaBase());
        $this->assertEquals('yacare_tramites_asociacionrequisito_listar', $this->item->obtenerRutaBase('listar'));
    }
}

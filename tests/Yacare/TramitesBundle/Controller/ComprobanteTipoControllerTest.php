<?php
namespace Yacare\TramitesBundle\Controller;

use Symfony\Component\HttpFoundation\Response;

/**
 * Prueba para el controlador de ComprobanteTipo.
 * 
 * @author Ezequiel Riquelme <rezequiel.tdf@gmail.com>
 * 
 * @see \Yacare\TramitesBundle\Controller\ComprobanteTipoController ComprobanteTipoController
 */
class ComprobanteTipoControllerTest extends \Tapir\BaseBundle\Controller\AbmControllerTest
{
    public function setup()
    {
        parent::setup();
        $this->item = new ComprobanteTipoController();
    }

    public function testConstructor()
    {
        $this->assertEquals('Yacare', $this->item->getVendorName());
        $this->assertEquals('Tramites', $this->item->getBundleName());
        $this->assertEquals('ComprobanteTipo', $this->item->getEntityName());
    }

    public function testBaseRoute()
    {
        $this->assertEquals('yacare_tramites_comprobantetipo', $this->item->obtenerRutaBase());
        $this->assertEquals('yacare_tramites_comprobantetipo_listar', $this->item->obtenerRutaBase('listar'));
    }
}

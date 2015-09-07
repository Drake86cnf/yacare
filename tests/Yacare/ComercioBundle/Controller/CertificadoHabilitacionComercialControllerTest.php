<?php
namespace Yacare\ComercioBundle\Controller;

use Symfony\Component\HttpFoundation\Response;

/**
 * Prueba para el controlador de CertificadoHabilitacionComercial.
 * 
 * @author Ezequiel Riquelme <rezequiel.tdf@gmail.com>
 * 
 * @see \Yacare\ComercioBundle\Controller\CertificadoHabilitacionComercialController CertificadoHabilitacionComercialController
 */
class CertificadoHabilitacionComercialControllerTest extends \Tapir\BaseBundle\Controller\AbmControllerTest
{
    public function setUp()
    {
        parent::setup();
        $this->item = new CertificadoHabilitacionComercialController();
    }

    public function testConstructor()
    {
        $this->assertEquals('Yacare', $this->item->getVendorName());
        $this->assertEquals('Comercio', $this->item->getBundleName());
        $this->assertEquals('CertificadoHabilitacionComercial', $this->item->getEntityName());
    }

    public function testBaseRoute()
    {
        $this->assertEquals('yacare_comercio_certificadohabilitacioncomercial', $this->item->obtenerRutaBase());
        $this->assertEquals('yacare_comercio_certificadohabilitacioncomercial_listar', 
            $this->item->obtenerRutaBase('listar'));
    }
}

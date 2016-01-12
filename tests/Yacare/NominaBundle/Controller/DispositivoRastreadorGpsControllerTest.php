<?php
namespace Yacare\NominaBundle\Controller;

use Symfony\Component\HttpFoundation\Response;

/**
 * Prueba para el controlador de  DispositivoRastreadorGps.
 * 
 * @author Ezequiel Riquelme <rezequiel.tdf@gmail.com>
 * 
 * @see \Yacare\NominaBundle\Controller\DispositivoRastreadorGpsController DispositivoRastreadorGpsController
 */
class DispositivoRastreadorGpsControllerTest extends \Tapir\AbmBundle\Controller\AbmControllerTest
{
    public function setup()
    {
        parent::setup();
        $this->item = new DispositivoRastreadorGpsController();
    }

    public function testConstructor()
    {
        $this->assertEquals('Yacare', $this->item->getVendorName());
        $this->assertEquals('Nomina', $this->item->getBundleName());
        $this->assertEquals('DispositivoRastreadorGps', $this->item->getEntityName());
    }

    public function testBaseRoute()
    {
        $this->assertEquals('yacare_nomina_dispositivorastreadorgps', $this->item->obtenerRutaBase());
        $this->assertEquals('yacare_nomina_dispositivorastreadorgps_listar', $this->item->obtenerRutaBase('listar'));
    }
}

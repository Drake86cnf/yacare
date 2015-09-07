<?php
namespace Yacare\RecursosHumanosBundle\Controller;

use Symfony\Component\HttpFoundation\Response;

/**
 * Prueba para el controlador de Agente.
 * 
 * @author Ezequiel Riquelme <rezequiel.tdf@gmail.com>
 * 
 * @see \Yacare\RecursosHumanosBundle\Controller\AgenteController AgenteController
 */
class AgenteControllerTest extends \Tapir\BaseBundle\Controller\AbmControllerTest
{
    public function setup()
    {
        parent::setup();
        $this->item = new AgenteController();
    }

    public function testConstructor()
    {
        $this->assertEquals('Yacare', $this->item->getVendorName());
        $this->assertEquals('RecursosHumanos', $this->item->getBundleName());
        $this->assertEquals('Agente', $this->item->getEntityName());
    }

    public function testBaseRoute()
    {
        $this->assertEquals('yacare_recursoshumanos_agente', $this->item->obtenerRutaBase());
        $this->assertEquals('yacare_recursoshumanos_agente_listar', $this->item->obtenerRutaBase('listar'));
    }
}

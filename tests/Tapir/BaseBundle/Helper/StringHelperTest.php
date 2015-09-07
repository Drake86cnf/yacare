<?php
namespace Tapir\BaseBundle\Helper;

use \Tests\Tapir\PruebaUnitaria;

/**
 * Prueba para el helper StringHelper.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 * 
 * @see \Tapir\BaseBundle\Helper\StringHelper StringHelper
 */
class StringHelperTest extends PruebaUnitaria
{
    public function testObtenerBundleYEntidad()
    {
        $Resultado = array('Comercio', 'Actividad');
        
        $this->assertEquals($Resultado, 
            StringHelper::ObtenerBundleYEntidad('Yacare\ComercioBundle\Controller\ActividadController'));
    }

    public function testObtenerRutaBase()
    {
        $this->assertEquals('yacare_comercio_actividad', 
            StringHelper::ObtenerRutaBase('\Yacare\ComercioBundle\Controller\ActividadController'));
        $this->assertEquals('yacare_comercio_actividad_editar', 
            StringHelper::ObtenerRutaBase('\Yacare\ComercioBundle\Controller\ActividadController', 'editar'));
    }

    public function testPonerTildes()
    {
        $this->assertEquals('nicolás', StringHelper::PonerTildes('nicolas'));
    }

    public function testArreglarProblemasConocidos()
    {
        $this->assertEquals('yugoslavia', StringHelper::ArreglarProblemasConocidos('yugoeslavia'));
    }
}

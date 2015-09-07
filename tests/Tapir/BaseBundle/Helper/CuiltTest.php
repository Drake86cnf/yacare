<?php
namespace Tapir\BaseBundle\Helper;

use \Tests\Tapir\PruebaUnitaria;

/**
 * Prueba para el helper Cuilt.
 * 
 * @author Ernesto Carrea <ernestocarre@gmail.com>
 * 
 * @see \Tapir\BaseBundle\Helper\Cuilt Cuilt
 */
class CuiltTest extends PruebaUnitaria
{
    public function testEsCuiltValida()
    {
        $this->assertTrue(Cuilt::EsCuiltValida('20-25248532-6'), 'La CUIT 20-25248532-6 debería ser válida.');
        $this->assertFalse(Cuilt::EsCuiltValida('20-25248532-7'), 'La CUIT 20-25248532-7 no debería ser válida.');
    }

    public function testFormatearCuilt()
    {
        $this->assertEquals('20-25248532-6', Cuilt::FormatearCuilt('20252485326'));
        $this->assertEquals('20-25248532-6', Cuilt::FormatearCuilt('20-25248532-6'));
    }
}

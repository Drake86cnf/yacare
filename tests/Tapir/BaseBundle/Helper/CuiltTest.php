<?php
namespace Tapir\BaseBundle\Helper;

use \Tests\Tapir\PruebaUnitaria;

class CuiltTest extends PruebaUnitaria
{

    public function testEsCuiltValido()
    {
        $this->assertTrue(Cuilt::EsCuiltValido('20-25248532-6'), 'La CUIT 20-25248532-7 debería ser válida.');
        $this->assertFalse(Cuilt::EsCuiltValido('20-25248532-7'), 'La CUIT 20-25248532-7 no debería ser válida.');
    }

    public function testFormatearCuilt()
    {
        $this->assertEquals('20-25248532-6', Cuilt::FormatearCuilt('20252485326'));
        $this->assertEquals('20-25248532-6', Cuilt::FormatearCuilt('20-25248532-6'));
    }
}

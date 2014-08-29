<?php
namespace Yacare\SeguridadBundle\Entity;

use Tapir\BaseBundle\Tests\PruebaUnitaria;

class CamaraTest extends PruebaUnitaria
{

    protected $item;

    public function setUp()
    {
        parent::setUp();
        
        $this->item = new Camara();
    }

    public function testCamaraTipo()
    {
        $Tipo = 'Fija';
        
        $this->item->setCamaraTipo($Tipo);
        
        $this->assertEquals($Tipo, $this->item->getCamaraTipo());
    }
}

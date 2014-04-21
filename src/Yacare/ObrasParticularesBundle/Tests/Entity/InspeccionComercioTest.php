<?php

namespace Yacare\ObrasParticularesBundle\Entity;

use Yacare\BaseBundle\Tests\PruebaUnitaria;

class InspeccionComercioTest extends PruebaUnitaria
{
    protected $item;

    public function setUp()
    {
        parent::setUp();

        $this->item = new InspeccionComercio();
    }


    public function testPropiedades()
    {
    }
}

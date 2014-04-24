<?php

namespace Yacare\RecursosHumanosBundle\Entity;

use Yacare\BaseBundle\Tests\PruebaUnitaria;

class AgenteTest extends \Yacare\BaseBundle\Tests\Entity\GenericEntityTest
{
    protected $item;

    public function setUp()
    {
        parent::setUp();

        $this->item = new Agente();
    }


    public function testPropiedades()
    {
        $this->ProbarPropiedad('Categoria', 21);
        $this->ProbarPropiedad('Categoria', 19);
    }

}

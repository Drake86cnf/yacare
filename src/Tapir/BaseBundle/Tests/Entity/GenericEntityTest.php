<?php

namespace Tapir\BaseBundle\Tests\Entity;

use Tapir\BaseBundle\Tests\PruebaUnitaria;

abstract class GenericEntityTest extends PruebaUnitaria
{
    public function ProbarPropiedad($nombrePropiedad, $valorDePrueba) {
        $setter = 'set' . $nombrePropiedad;
        $getter = 'get' . $nombrePropiedad;
        
        $this->item->$setter($valorDePrueba);
        $this->assertEquals($valorDePrueba, $this->item->$getter());
    }
}

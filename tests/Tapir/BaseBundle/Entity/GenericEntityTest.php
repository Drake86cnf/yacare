<?php
namespace Tapir\BaseBundle\Entity;

use \Tests\Tapir\PruebaUnitaria;

/**
 * Prueba general para entidades.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
abstract class GenericEntityTest extends \Tests\Tapir\PruebaUnitaria
{
    public function ProbarPropiedad($nombrePropiedad, $valorDePrueba)
    {
        $setter = 'set' . $nombrePropiedad;
        $getter = 'get' . $nombrePropiedad;
        
        $this->item->$setter($valorDePrueba);
        $this->assertEquals($valorDePrueba, $this->item->$getter());
    }
}

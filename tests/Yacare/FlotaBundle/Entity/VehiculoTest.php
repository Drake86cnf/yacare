<?php
namespace Yacare\FlotaBundle\Entity;

use Tapir\BaseBundle\Tests\Entity\GenericEntityTest;

/**
 * Prueba de la entidad Vehiculo.
 *
 * @author Ernesto Carrea <equistango@gmail.com>
 *
 * @see \Yacare\FlotaBundle\Entity\Vehiculo YacareFlotaBundle:Vehiculo
 */
class VehiculoTest extends \Tapir\BaseBundle\Entity\GenericEntityTest
{
    protected $item;

    public function setUp()
    {
        parent::setUp();

        $this->item = new Vehiculo();
    }


    public function testPropiedades()
    {
        $this->ProbarPropiedad('Combustible', 'diesel-3');
    }
}

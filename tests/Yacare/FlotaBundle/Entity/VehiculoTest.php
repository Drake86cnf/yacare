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

        $this->item = new Pais();
    }

    /**
     * Prueba el código del trait "ConId"
     */
    public function testConId()
    {
        $this->item->setId(32);

        $this->assertEquals(32, $this->item->getId());
        $this->assertEquals('032-4', $this->item->getDamm());
        $this->assertEquals('http://yacare.riogrande.gob.ar/cp/?en=Base+Pais&id=32&ver=', $this->item->getYri());
        $this->assertEquals('aHR0cDovL3lhY2FyZS5yaW9ncmFuZGUuZ29iLmFyL2NwLz9lbj1CYXNlK1BhaXMmaWQ9MzImdmVyPQ==',
            $this->item->getYri64());
    }

    public function testPropiedades()
    {
        $this->ProbarPropiedad('Combustible', 'diesel-3');
    }
}

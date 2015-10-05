<?php
namespace Yacare\BaseBundle\Entity;

use Tapir\BaseBundle\Tests\Entity\GenericEntityTest;

/**
 * Prueba de la entidad País.
 *
 * @author eriquelme
 *
 * @see \Yacare\BaseBundle\Entity\Pais YacareBaseBundle:Pais
 */
class PaisTest extends \Tapir\BaseBundle\Entity\GenericEntityTest
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
        $this->ProbarPropiedad('IsoAlfa2', 'AR');
    }

    /**
     * Prueba el código del trait "ConNombre"
     */
    public function testConNombre()
    {
        $Nombre = 'Ernestópolis';

        $this->ProbarPropiedad('Nombre', $Nombre);

        // Prueba el toString()
        $this->assertEquals($Nombre, (string) $this->item);
    }

    /**
     * Prueba el código del trait "Versionable"
     */
    public function testVersionable()
    {
        $this->item->setVersion(55);

        $this->assertEquals(55, $this->item->getVersion());

        // TODO: probar que al persistir incrementa la versión
    }
}

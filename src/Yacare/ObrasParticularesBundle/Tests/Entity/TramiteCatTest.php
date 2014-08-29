<?php
namespace Yacare\ObrasParticularesBundle\Entity;

use Tapir\BaseBundle\Tests\Entity\GenericEntityTest;

class TramiteCatTest extends GenericEntityTest
{

    protected $item;

    public function setUp()
    {
        parent::setUp();
        
        $this->item = new TramiteCat();
    }

    public function testPropiedades()
    {
        // $this->ProbarPropiedad('Superficie', 3.55);
        // $this->ProbarPropiedad('NumeroSolicitud', 55);
        // $this->ProbarPropiedad('ActividadNombre', 'Prueba de actividad');
        // $this->ProbarPropiedad('TitularNombre', 'Prueba de titular');
    }
}

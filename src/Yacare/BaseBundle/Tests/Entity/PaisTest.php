<?php

namespace Yacare\BaseBundle\Entity;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Yacare\BaseBundle\Tests\YacareTestCase;

class PaisTest extends YacareTestCase
{
    protected $pais;

    public function setUp()
    {
        parent::setUp();

        $this->pais = new Pais();
    }

    public function testToString()
    {
        $Nombre = 'Ernestópolis';

        $this->pais->setNombre($Nombre);

        $this->assertEquals($Nombre, (string)$this->pais);
    }
}

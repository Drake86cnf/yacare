<?php
namespace Tapir\BaseBundle\Tests\Controller;

use Tapir\BaseBundle\Tests\PruebaFuncional;

/*
 * Prueba base para todas las pruebas que derivan de AmbController
 */
abstract class GenericAbmControllerTest extends PruebaFuncional
{

    protected $item;

    public function testlistarAction()
    {
        $crawler = $this->clientRequestAction('listar');
        $this->clientTestResponse($crawler);
        
        $this->assertGreaterThan(0, $crawler->filter('#page-title')
            ->count(), 'Probando que el listado tenga un título');
    }

    public function testbuscarAction()
    {
        if (\Tapir\BaseBundle\Helper\ClassHelper::UsaTrait($this->item, 'Tapir\\BaseBundle\\Controller\\ConBuscar') == false) {
            $this->markTestSkipped('Este controlador no soporta búsquedas.');
            return;
        }
        
        $crawler = $this->clientRequestAction('buscar');
        $this->clientTestResponse($crawler);
        
        $this->assertGreaterThan(0, $crawler->filter('#page-title')
            ->count());
    }
}

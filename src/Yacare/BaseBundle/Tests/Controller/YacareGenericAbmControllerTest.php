<?php

namespace Yacare\BaseBundle\Tests\Controller;

use Yacare\BaseBundle\Tests\PruebaFuncional;

/*
 * Prueba base para todas las pruebas que derivan de YacareAmbController
 */
class YacareGenericAbmControllerTest extends PruebaFuncional
{
    protected $item;

    
    public function testlistarAction()
    {
        $crawler = $this->clientRequestAction('listar');

        $this->assertTrue($this->client->getResponse()->isSuccessful(), 'Probando que la página listar sea accesible');

        $this->assertGreaterThan(
            0,
            $crawler->filter('#page-title')->count(),
            'Probando que el listado tenga un título'
        );
    }
    
    public function testbuscarAction()
    {
        if(\Yacare\BaseBundle\Helper\ClassHelper::UsaTrait($this->item, 'Yacare\\BaseBundle\\Controller\\ConBuscar') == false) {
            return;
        }
        
        /* $crawler = $this->clientRequest('GET', $this->getUrl($this->item->obtenerRutaBase('buscar')));

        $this->assertTrue($this->client->getResponse()->isSuccessful());

        $this->assertGreaterThan(
            0,
            $crawler->filter('#page-title')->count()
        ); */
    }
}

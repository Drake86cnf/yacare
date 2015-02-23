<?php
namespace Tapir\BaseBundle\Controller;

use \Tests\Tapir\PruebaFuncional;

/*
 * Prueba base para todos los controladores que derivan de AmbController.
 * 
 * @abstract
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
abstract class AbmControllerTest extends \Tapir\BaseBundle\Controller\BaseControllerTest
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

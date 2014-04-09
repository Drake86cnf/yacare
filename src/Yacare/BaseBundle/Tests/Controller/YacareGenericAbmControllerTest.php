<?php

namespace Yacare\BaseBundle\Tests\Controller;

use Yacare\BaseBundle\Tests\YacareWebTestCase;
use Symfony\Component\HttpFoundation\Response;

/*
 * Prueba base para todas las pruebas que derivan de YacareAmbController
 */
abstract class YacareGenericAbmControllerTest extends YacareWebTestCase
{
    protected $client;
    protected $item;
    
    public function setUp()
    {
        parent::setUp();

        /* $user = new \Yacare\Basebundle\Entity\Persona();
        $user->setNombre('Ernesto');
        $user->setApellido('Carrea');
        $token = new UsernamePasswordToken($user, null, 'secured_area', array('ROLE_IDDQD'));
        self::$kernel->getContainer()->get('security.context')->setToken($token); */
        
        /*
         *  TODO: hacer que permita autenticar un usuario falso
         */
        $this->client = static::createClient();
    }
    
    public function clientRequest($method, $path) {
        $crawler = $this->client->request($method, $path);
        
        if (!$this->client->getResponse()->isSuccessful()) {
            echo $this->client->getResponse()->getContent();
            $block = $crawler->filter('div.text-exception h1');
            if ($block->count()) {
                $error = $block->text();
                echo $error;
            }
        }
        
        return $crawler;
    }
    
    public function testlistarAction()
    {
        $crawler = $this->clientRequest('GET', '/base/persona/listar/');

        $this->assertTrue($this->client->getResponse()->isSuccessful());

        $this->assertGreaterThan(
            0,
            $crawler->filter('#page-title')->count()
        );
    }
}

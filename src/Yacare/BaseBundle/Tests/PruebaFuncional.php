<?php

namespace Yacare\BaseBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PruebaFuncional extends WebTestCase
{
    protected $client;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;
    
    /**
     * {@inheritDoc}
     */
    public function setUp()
    {
        static::$kernel = static::createKernel();
        static::$kernel->boot();
        $this->em = static::$kernel->getContainer()
            ->get('doctrine')
            ->getManager()
        ;
        
        // Creo un cliente HTTP que va a hacer las solicitudes
        $this->client = static::createClient(array('environment' => 'test'), array(
            'PHP_AUTH_USER' => 'pruebas',
            'PHP_AUTH_PW'   => 'pruebas',
        ));

        /*
        // Login via form
        $crawler = $this->client->request('GET', '/login');
        $form = $crawler->selectButton('Ingresar')->form();
        $crawler = $this->client->submit(
            $form,
            array(
                '_username' => 'pruebas',
                '_password' => 'pruebas'
            )
        );
        $crawler = $this->client->followRedirect();
        $this->assertTrue($crawler->filter('html:contains("Bienvenido")')->count() > 0, 'Falló la autenticación de usuario "pruebas".');
         */
    }
    
    /*
     * Hace un request HTTP de una acción
     */
    public function clientRequestAction($actionname, $method = 'GET') {
        return $this->clientRequest($this->getUrl($this->item->getBaseRoute($actionname)));
    }
    
    /*
     * Hace un request HTTP de una URL
     */
    public function clientRequest($path, $method = 'GET') {
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

    /**
     * {@inheritDoc}
     */
    protected function tearDown()
    {
        parent::tearDown();

        if($this->em) {
            $this->em->close();
        }
    }
    
    
    protected function getUrl($route, $params = array()) {
        return static::$kernel->getContainer()->get('router')->generate($route, $params, false);
    }
}

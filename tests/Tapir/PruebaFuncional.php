<?php
namespace Tests\Tapir;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Clase base para todas las pruebas funcionales.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 * @abstract
 */
abstract class PruebaFuncional extends WebTestCase
{
    protected $client;
    
    /**
     * El entity manager de Doctrine.
     *
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    public function setUp()
    {
        static::$kernel = static::createKernel();
        static::$kernel->boot();
        $this->em = static::$kernel->getContainer()->get('doctrine')->getManager();
        
        // Creo un cliente HTTP que va a hacer las solicitudes
        $this->client = static::createClient(array('environment' => 'test'), 
            array('PHP_AUTH_USER' => 'pruebas', 'PHP_AUTH_PW' => 'pruebas'));
        
        // $this->client->followRedirects();
        
        /*
         * Login via form
         * $crawler = $this->client->request('GET', '/login');
         * $form = $crawler->selectButton('Ingresar')->form();
         * $crawler = $this->client->submit( $form, array( '_username' => 'pruebas', '_password' => 'pruebas' ) );
         * $crawler = $this->client->followRedirect();
         * $this->assertTrue($crawler->filter('html:contains("Bienvenido")')->count() > 0, 'Falló la autenticación de
         * usuario "pruebas".');
         */
    }

    /**
     * Hace un request HTTP de una acción por nombre
     */
    public function clientRequestAction($actionname, $params = array(), $method = 'GET')
    {
        $url = $this->getUrl($this->item->obtenerRutaBase($actionname));
        
        return $this->clientRequest($url, $params, $method);
    }

    /**
     * Hace un request HTTP de una URL
     */
    public function clientRequest($path, $params = array(), $method = 'GET')
    {
        $crawler = $this->client->request($method, $path, $params);
        $this->clientTestResponse($crawler);
        
        return $crawler;
    }

    /**
     * Prueba que la respuesta se exitosa.
     *
     * Si no lo es, intenta obtener y mostrar un mensaje de error.
     */
    public function clientTestResponse($crawler)
    {
        if (! $this->client->getResponse()->isSuccessful()) {
            $block = $crawler->filter('div.text-exception h1');
            if ($block->count() == 0) {
                $block = $crawler->filter('h1');
            }
            echo substr(strip_tags($this->client->getResponse()->getContent()), 0, 4096);
            if ($block->count()) {
                $error = $block->text();
                
                return $error;
            }
        }        
        return false;
    }

    /**
     * {@inheritDoc}
     */
    protected function tearDown()
    {
        parent::tearDown();
        
        if ($this->em) {
            $this->em->close();
        }
    }

    protected function getUrl($route, $params = array())
    {
        return static::$kernel->getContainer()->get('router')->generate($route, $params, false);
    }
}

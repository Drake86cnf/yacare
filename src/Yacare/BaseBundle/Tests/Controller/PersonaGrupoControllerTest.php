<?php

namespace Yacare\BaseBundle\Controller;

use Yacare\BaseBundle\Tests\YacareWebTestCase;
use Symfony\Component\HttpFoundation\Response;

class PersonaGrupoControllerTest extends \Yacare\BaseBundle\Tests\Controller\YacareGenericAbmControllerTest
{
    public function setUp()
    {
        parent::setUp();

        $this->item = new PersonaGrupoController();
    }
    
    public function testCrear() {
        $crawler = $this->clientRequestAction('editar_1');
        
        $this->assertTrue($this->client->getResponse()->isSuccessful(), 'Probando que la página de crear sea accesible');

        $form = $crawler->selectButton('Guardar')->form();

        // set some values
        $form['yacare_basebundle_personagrupotype[Nombre]'] = 'Grupo de pruebas';

        // submit the form
        $crawler = $this->client->submit($form);
        $this->client->followRedirect();
        
        $this->assertFalse($this->clientTestResponse($crawler));
        
        //echo $this->client->getResponse()->getContent();
    }
}

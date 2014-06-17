<?php

namespace Yacare\BaseBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Controlador de personas.
 * 
 * @Route("persona/")
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class PersonaController extends \Tapir\BaseBundle\Controller\AbmController
{
    Use \Yacare\BaseBundle\Controller\ConEliminar;
    Use \Tapir\BaseBundle\Controller\ConPerfil;
    
    function __construct() {
        $this->BuscarPor = 'NombreVisible, Username, RazonSocial, DocumentoNumero, Cuilt, Email';
        parent::__construct();
    }
}

<?php

namespace Yacare\ObrasParticularesBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Controlador de agentes.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 * 
 * @Route("matricula/")
 */
class MatriculaController extends \Tapir\BaseBundle\Controller\AbmController
{
    function IniciarVariables() {
        parent::IniciarVariables();

        $this->BuscarPor = 'id, p.NombreVisible, p.DocumentoNumero';
       
    }
}

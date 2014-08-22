<?php

namespace Yacare\ObrasParticularesBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Controlador de matriculados.
 * 
 * @author Alejandro Diaz <alediaz.rc@gmail.com>
 * 
 * @Route("matriculado/")
 */
class MatriculadoController extends \Tapir\BaseBundle\Controller\AbmController 
{
    function IniciarVariables(){
        parent::IniciarVariables();

        $this->BuscarPor= 'p.Nombre , p.id ,p.Documento';
    }
}
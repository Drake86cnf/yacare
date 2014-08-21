<?php

namespace Yacare\ObrasParticularesBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
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
      

    function IniciarVariables(){
        parent::IniciarVariables();
        
        $this->BuscarPor= 'p.Nombre , p.id ,p.Documento';
        
    }
    
    
}    
    
{
    
    

    
}

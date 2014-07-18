<?php

namespace Yacare\BromatologiaBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("actabromatologicaveterinaria/")
 */
class ActaBromatologicaVeterinariaController extends \Tapir\BaseBundle\Controller\AbmController
{
    use \Tapir\BaseBundle\Controller\ConEliminar;
    
    function IniciarVariables() {
        parent::IniciarVariables();

        $this->BuscarPor = 'id, p.NombreVisible';
        $this->Joins[] = " JOIN r.Persona p";       
    }
}

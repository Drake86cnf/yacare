<?php

namespace Yacare\BromatologiaBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("actabromatologicaveterinaria/")
 */
class ActaBromatologicaVeterinariaController extends \Tapir\BaseBundle\Controller\AbmController
{
    use \Yacare\BaseBundle\Controller\ConEliminar;
    
    function __construct() {
        parent::__construct();

        $this->BuscarPor = 'id, p.NombreVisible';
        $this->Joins[] = " JOIN r.Persona p";       
    }
}

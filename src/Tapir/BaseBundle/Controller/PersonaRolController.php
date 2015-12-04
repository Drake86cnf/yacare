<?php
namespace Tapir\BaseBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Controlador de roles de personas.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 * 
 * @Route("personarol/")
 */
class PersonaRolController extends \Tapir\AbmBundle\Controller\AbmController
{
    use \Tapir\AbmBundle\Controller\ConEliminar;

    function IniciarVariables()
    {
        parent::IniciarVariables();
        
        $this->EntityLabel = 'Rol (personas)';
        $this->OrderBy = 'r.Nombre ASC';
    }
}

<?php

namespace Yacare\BaseBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Controlador de roles de personas.
 * 
 * @Route("personarol/")
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class PersonaRolController extends YacareAbmController
{
    use \Yacare\BaseBundle\Controller\ConEliminar;
}

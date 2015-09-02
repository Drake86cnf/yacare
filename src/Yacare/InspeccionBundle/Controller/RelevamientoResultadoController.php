<?php
namespace Yacare\InspeccionBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Controlador de resultados del relevamiento.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 * 
 * @Route("relevamiento/resultado/")
 */
class RelevamientoResultadoController extends \Tapir\BaseBundle\Controller\AbmController
{
    use \Tapir\BaseBundle\Controller\ConEliminar;

    function IniciarVariables()
    {
        parent::IniciarVariables();
        
        $this->OrderBy = 'Grupo, Nombre';
    }
}

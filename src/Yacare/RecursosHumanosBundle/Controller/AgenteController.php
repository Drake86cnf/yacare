<?php
namespace Yacare\RecursosHumanosBundle\Controller;

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
 *         @Route("agente/")
 */
class AgenteController extends \Tapir\BaseBundle\Controller\AbmController
{

    function IniciarVariables()
    {
        parent::IniciarVariables();
        
        $this->BuscarPor = 'id, p.NombreVisible, p.DocumentoNumero';
        if(in_array('r.Persona p', $this->Joins) == false) {
        	$this->Joins[] = 'JOIN r.Persona p';
        }
        
        $this->OrderBy = 'p.NombreVisible';
    }
}

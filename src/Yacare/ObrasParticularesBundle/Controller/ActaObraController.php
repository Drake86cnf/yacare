<?php
namespace Yacare\ObrasParticularesBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Controlador de actas de obra.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 * @author Ezequiel Riquelme <rezequiel.tdf@gmail.com>
 * 
 * @Route("actaobra/")
 * @Template()
 */
class ActaObraController extends \Tapir\AbmBundle\Controller\AbmController
{
    use \Tapir\AbmBundle\Controller\ConEliminar;

    function IniciarVariables()
    {
        parent::IniciarVariables();
        
        // TODO: Implementar que filtre por fecha
        $this->BuscarPor = 'Numero, Fecha, fp.NombreVisible';
        
        if (in_array('r.FuncionarioPrincipal fp', $this->Joins) == false) {
            $this->Joins[] = 'JOIN r.FuncionarioPrincipal fp';
        }
        
        $this->OrderBy = 'r.Fecha DESC';
    }
}

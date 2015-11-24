<?php
namespace Yacare\ObrasParticularesBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
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
    
    /**
     * Emite el descargo de un acta en particular.
     * 
     * @Route("emitirdescargo/")
     * @Template()
     */
    public function emitirdescargoAction() 
    {
        return array();
    }
    
    /**
     * Ver el descargo de un acta.
     *
     * @see verAction() verAction()
     *
     * @Route("verdescargo/")
     * @Template()
     */
    public function verdescargoAction(Request $request)
    {
        return parent::verAction($request);
    }
}

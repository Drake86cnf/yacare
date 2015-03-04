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
 *         @Route("matriculado/")
 */
class MatriculadoController extends \Tapir\BaseBundle\Controller\AbmController
{
    function IniciarVariables()
    {
        parent::IniciarVariables();
        
        $this->BuscarPor = 'p.Nombre , p.id ,p.Documento';
    }
    
    
    /**
     * Obtiene el listado de matriculados con pago al día, sin paginar.
     *
     * @Route("listarhabilitados/")
     * @Template()
     */
    public function listarhabilitadosAction(Request $request) {
        $this->Where = 'r.FechaVencimiento>CURRENT_DATE()';
        $this->Paginar = false;
        $this->Joins[] = 'JOIN r.Persona p';
        $this->OrderBy = 'p.NombreVisible';
    
        $res = parent::listarAction($request);
        
        $res['fechalistado'] = new \DateTime();
        
        return $res;
    }
}
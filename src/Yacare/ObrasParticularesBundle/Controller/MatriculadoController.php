<?php
namespace Yacare\ObrasParticularesBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Controlador de matriculados.
 *
 * @author Alejandro Diaz <alediaz.rc@gmail.com>
 *        
 * @Route("matriculado/")
 * @Security("has_role('ROLE_IDDQD') or has_role('ROLE_OBRAS_PARTICULARES') or has_role('ROLE_OBRAS_PARTICULARES_ADMINISTRADOR')")
 */
class MatriculadoController extends \Tapir\AbmBundle\Controller\AbmController
{
    use \Tapir\AbmBundle\Controller\ConBuscar;

    function IniciarVariables()
    {
        parent::IniciarVariables();
        
        $this->Joins[] = 'JOIN r.Persona p';
        $this->OrderBy = 'p.NombreVisible';
        $this->BuscarPor = 'r.id, p.NombreVisible , p.DocumentoNumero';
    }

    /**
     * Obtiene el listado de matriculados con pago al día, sin paginar.
     *
     * @Route("listarhabilitados/")
     * @Template()
     */
    public function listarhabilitadosAction(Request $request)
    {
        $this->Where = 'r.FechaVencimiento>CURRENT_DATE()';
        $this->Paginar = false;
        
        $res = parent::listarAction($request);
        
        $res['fechalistado'] = new \DateTime();
        
        return $res;
    }
    
    /**
     * Edición de un matriculado.
     * 
     * @see \Tapir\AbmBundle\Controller\AbmController::editarAction() AbmController::editarAction()
     * 
     * @Route("editar/")
     * @Route("crear/")
     * @Security("has_role('ROLE_IDDQD') or has_role('ROLE_OBRAS_PARTICULARES_ADMINISTRADOR')")
     * @Template()
     */
    public function editarAction(Request $request)
    {
        return parent::editarAction($request);
    }
    
    /**
     * Guardar un matriculado.
     * 
     * @see \Tapir\AbmBundle\Controller\AbmController::guardarAction() AbmController::guardarAction()
     * 
     * @Route("guardar/")
     * @Sensio\Bundle\FrameworkExtraBundle\Configuration\Method("POST")
     * @Security("has_role('ROLE_IDDQD') or has_role('ROLE_OBRAS_PARTICULARES_ADMINISTRADOR')")
     * @Template()
     */
    public function guardarAction(Request $request)
    {
        return parent::guardarAction($request);
    }
}

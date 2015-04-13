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
    use \Tapir\BaseBundle\Controller\ConBuscar;

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
}
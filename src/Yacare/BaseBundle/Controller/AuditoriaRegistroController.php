<?php
namespace Yacare\BaseBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Controlador de registros de auditoría.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 * 
 * @Route("auditoriaregistro/")
 */
class AuditoriaRegistroController extends \Tapir\AbmBundle\Controller\AbmController
{
    function IniciarVariables()
    {
        $this->CompleteEntityName = '\\Tapir\\BaseBundle\\Entity\\AuditoriaRegistro';
        parent::IniciarVariables();
        $this->OrderBy = 'createdAt';
        $this->ConservarVariables[] = 'tipo';
        $this->ConservarVariables[] = 'id';
    }
    
    /**
     * @Route("listar")
     * @Template()
     */
    public function listarAction(Request $request)
    {
        $em = $this->getEm();
        
        $tipo = $this->ObtenerVariable($request, 'tipo');
        $id = $this->ObtenerVariable($request, 'id');
        
        $Entidad = null;
        if ($tipo) {
            $this->Where .= " AND r.ElementoTipo = '" . $tipo ."'";
            if($id) {
                $this->Where .= " AND r.ElementoId = " . $id;
                $Entidad = $em->getRepository($tipo)->find($id);
            }
        }
        
        $ResultadoListar = parent::listarAction($request);
        $res = $ResultadoListar['res'];
        
        $res->Entidad = $Entidad;
        
        return $ResultadoListar;
    }
}

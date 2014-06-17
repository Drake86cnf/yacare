<?php

namespace Yacare\InspeccionBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("relevamientoasignaciondetalle/")
 */
class RelevamientoAsignacionDetalleController extends \Tapir\BaseBundle\Controller\AbmController
{
    function __construct() {
        $this->BundleName = 'Inspeccion';
        $this->EntityName = 'RelevamientoAsignacionDetalle';
        $this->Where = 'r.ResultadosCantidad>0';
        parent::__construct();
    }
    
    /**
     * @Route("listarrelevamiento/{id}")
     * @Template("YacareInspeccionBundle:RelevamientoAsignacionDetalle:listar.html.twig")
     */
    public function listarrelevamientoAction(Request $request, $id)
    {
        $res = parent::listarAction($request);
        $res['id'] = $id;
        
        return $res;
    }
}

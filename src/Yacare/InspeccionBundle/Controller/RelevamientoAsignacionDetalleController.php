<?php

namespace Yacare\InspeccionBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("relevamientoasignaciondetalle")
 */
class RelevamientoAsignacionDetalleController extends \Yacare\BaseBundle\Controller\YacareBaseController
{
    function __construct() {
        $this->BundleName = 'Inspeccion';
        $this->EntityName = 'RelevamientoAsignacionDetalle';
        $this->UsePaginator = true;
        $this->Where = 'r.Resultado1 IS NOT NULL';
        parent::__construct();
    }

    /**
     * @Route("relevamiento/{relevamiento}")
     * @Template()
     */
    public function relevamientoAction($relevamiento)
    {
        return parent::listarAction();
    }   
}

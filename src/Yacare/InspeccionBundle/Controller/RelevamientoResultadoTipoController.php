<?php

namespace Yacare\InspeccionBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("relevamiento/resutlado/tipo/")
 */
class RelevamientoResultadoTipoController extends \Yacare\BaseBundle\Controller\YacareBaseController
{
    function __construct() {
        $this->BundleName = 'Inspeccion';
        $this->EntityName = 'RelevamientoResultadoTipo';
        $this->UsePaginator = true;
        $this->OrderBy = 'r.Grupo, r.Nombre';
        parent::__construct();
    }
}

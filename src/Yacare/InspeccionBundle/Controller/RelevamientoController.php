<?php

namespace Yacare\InspeccionBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("relevamiento/")
 */
class RelevamientoController extends \Yacare\BaseBundle\Controller\YacareBaseController
{
    function __construct() {
        $this->BundleName = 'Inspeccion';
        $this->EntityName = 'Relevamiento';
        $this->UsePaginator = true;
        parent::__construct();
    }
}

<?php

namespace Yacare\InspeccionBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("relevamiento/")
 */
class RelevamientoController extends \Yacare\BaseBundle\Controller\YacareAbmController
{
    function __construct() {
        $this->BundleName = 'Inspeccion';
        $this->EntityName = 'Relevamiento';
        parent::__construct();
    }
}

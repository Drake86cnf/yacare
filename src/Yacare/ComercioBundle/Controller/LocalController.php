<?php

namespace Yacare\ComercioBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("local/")
 */
class LocalController extends \Yacare\BaseBundle\Controller\YacareAbmController
{
    use \Yacare\BaseBundle\Controller\ConEliminar;

    public function __construct() {
        $this->BundleName = 'Comercio';
        $this->EntityName = 'Local';
        parent::__construct();
    }
}

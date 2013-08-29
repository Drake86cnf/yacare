<?php

namespace Yacare\ComercioBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("actividad/")
 */
class ActividadController extends \Yacare\BaseBundle\Controller\YacareBaseController
{
    public function __construct() {
        $this->BundleName = 'Comercio';
        $this->EntityName = 'Actividad';
        parent::__construct();
    }
}

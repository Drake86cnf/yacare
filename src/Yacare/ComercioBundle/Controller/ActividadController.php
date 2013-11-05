<?php

namespace Yacare\ComercioBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("actividad/")
 */
class ActividadController extends \Yacare\BaseBundle\Controller\YacareAbmController
{
    public function __construct() {
        $this->BundleName = 'Comercio';
        $this->EntityName = 'Actividad';
        $this->BuscarPor = 'Nombre,Clamae2014,Incluye,NoIncluye';
        parent::__construct();
    }
}

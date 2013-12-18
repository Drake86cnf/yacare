<?php

namespace Yacare\TramitesBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("requisito/")
 */
class RequisitoController extends \Yacare\BaseBundle\Controller\YacareAbmController
{
    public function __construct() {
        parent::__construct();
        $this->ConservarVariables = array ('filtro_buscar');
        $this->Where = 'r.TramiteTipoEspejo IS NULL';
    }
}

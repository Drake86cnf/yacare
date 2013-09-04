<?php

namespace Yacare\TramitesBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("requisito/")
 */
class RequisitoController extends \Yacare\BaseBundle\Controller\YacareBaseController
{
    public function __construct() {
        $this->BundleName = 'Tramites';
        $this->EntityName = 'Requisito';
        $this->ConservarVariables = array ('filtro_buscar');
        parent::__construct();
    }
}

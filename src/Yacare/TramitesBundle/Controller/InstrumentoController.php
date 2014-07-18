<?php

namespace Yacare\TramitesBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("instrumento/")
 */
class InstrumentoController extends \Tapir\BaseBundle\Controller\AbmController
{
    function IniciarVariables() {
        parent::IniciarVariables();
        
        $this->ConservarVariables = array ('filtro_buscar');
    }
}

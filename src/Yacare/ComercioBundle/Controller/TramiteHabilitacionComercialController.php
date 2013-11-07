<?php

namespace Yacare\ComercioBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("tramitehabilitacioncomercial/")
 */
class TramiteHabilitacionComercialController extends \Yacare\TramitesBundle\Controller\TramiteController
{
    
    /**
     * @Route("ver/{id}")
     * @Template()
     */
    function verAction($id = null) {
        return $this->editarAction($id);
    }
}

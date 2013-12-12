<?php

namespace Yacare\ComercioBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("comercio/")
 */
class ComercioController extends \Yacare\BaseBundle\Controller\YacareAbmController
{
    /**
     * @Route("altamanual/")
     * @Template()
     */
    function altamanualAction() {
        return $this->ArrastrarVariables();
    }
}

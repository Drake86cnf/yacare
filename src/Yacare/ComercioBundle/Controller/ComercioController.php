<?php

namespace Yacare\ComercioBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("comercio/")
 */
class ComercioController extends \Tapir\BaseBundle\Controller\AbmController
{
    use \Tapir\BaseBundle\Controller\ConBuscar;
    
    /**
     * @Route("altamanual/")
     * @Template()
     */
    function altamanualAction() {
        return $this->ArrastrarVariables();
    }
}

<?php

namespace Yacare\RecursosHumanosBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("agente/")
 */
class AgenteController extends \Yacare\BaseBundle\Controller\YacareBaseController
{
    function __construct() {
        $this->BundleName = 'RecursosHumanos';
        $this->EntityName = 'Agente';
        parent::__construct();
    }
}

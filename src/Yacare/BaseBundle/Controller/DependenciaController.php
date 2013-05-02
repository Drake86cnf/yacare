<?php

namespace Yacare\BaseBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("dependencia/")
 */
class DependenciaController extends YacareBaseController
{
    function __construct() {
        $this->BundleName = 'Base';
        $this->EntityName = 'Dependencia';
        parent::__construct();
    }
}

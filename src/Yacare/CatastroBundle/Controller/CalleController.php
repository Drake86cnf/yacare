<?php

namespace Yacare\CatastroBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("calle/")
 */
class CalleController extends \Yacare\BaseBundle\Controller\YacareAbmController
{
    public function __construct() {
        $this->BundleName = 'Catastro';
        $this->EntityName = 'Calle';
        parent::__construct();
    }
}

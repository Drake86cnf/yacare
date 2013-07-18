<?php

namespace Yacare\ComprasBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("licitacion/")
 */
class LicitacionController extends \Yacare\BaseBundle\Controller\YacareBaseController
{
    public function __construct() {
        $this->BundleName = 'Compras';
        $this->EntityName = 'Licitacion';
        parent::__construct();
    }
}

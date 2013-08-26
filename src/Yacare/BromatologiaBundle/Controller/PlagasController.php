<?php

namespace Yacare\BromatologiaBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("plagas/")
 */
class PlagasController extends \Yacare\BaseBundle\Controller\YacareBaseController
{
    public function __construct() {
        $this->BundleName = 'Bromatologia';
        $this->EntityName = 'Plagas';
        parent::__construct();
    }
}

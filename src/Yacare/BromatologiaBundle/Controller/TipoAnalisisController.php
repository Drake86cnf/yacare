<?php

namespace Yacare\BromatologiaBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("tipoanalisis/")
 */
class TipoAnalisisController extends \Yacare\BaseBundle\Controller\YacareBaseController
{
    public function __construct() {
        $this->BundleName = 'Bromatologia';
        $this->EntityName = 'TipoAnalisis';
        parent::__construct();
    }
}

<?php

namespace Yacare\BromatologiaBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("desinfeccionlocal/")
 */
class DesinfeccionLocalController extends \Yacare\BaseBundle\Controller\YacareBaseController
{
    public function __construct() {
        $this->BundleName = 'Bromatologia';
        $this->EntityName = 'DesinfeccionLocal';
        parent::__construct();
    }
}

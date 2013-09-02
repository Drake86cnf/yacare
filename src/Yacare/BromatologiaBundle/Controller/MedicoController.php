<?php

namespace Yacare\BromatologiaBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("medico/")
 */
class MedicoController extends \Yacare\BaseBundle\Controller\YacareBaseController
{
    public function __construct() {
        $this->BundleName = 'Bromatologia';
        $this->EntityName = 'Medico';
        parent::__construct();
    }
}

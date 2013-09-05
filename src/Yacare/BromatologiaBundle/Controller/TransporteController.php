<?php

namespace Yacare\BromatologiaBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("transporte/")
 */
class TransporteController extends \Yacare\BaseBundle\Controller\YacareBaseController
{
    use \Yacare\BaseBundle\Controller\ConEliminar;
    
    public function __construct() {
        $this->BundleName = 'Bromatologia';
        $this->EntityName = 'Transporte';
        parent::__construct();
    }
}

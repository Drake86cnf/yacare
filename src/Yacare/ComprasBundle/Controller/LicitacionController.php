<?php

namespace Yacare\ComprasBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;


/**
 * @Route("licitacion/")
 */
class LicitacionController extends \Yacare\BaseBundle\Controller\YacareAbmController
{
    use \Yacare\BaseBundle\Controller\ConImprimir;
    use \Yacare\BaseBundle\Controller\ConEliminar;
    use \Yacare\BaseBundle\Controller\ConQr;
    
    public function __construct() {
        $this->BundleName = 'Compras';
        $this->EntityName = 'Licitacion';
        parent::__construct();
    }
}

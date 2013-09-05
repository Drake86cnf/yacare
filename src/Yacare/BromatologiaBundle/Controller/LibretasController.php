<?php

namespace Yacare\BromatologiaBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("libretas/")
 */
class LibretasController extends \Yacare\BaseBundle\Controller\YacareBaseController
{
    use \Yacare\BaseBundle\Controller\ConEliminar;
    
    public function __construct() {
        $this->BundleName = 'Bromatologia';
        $this->EntityName = 'Libretas';
        parent::__construct();
    }
}

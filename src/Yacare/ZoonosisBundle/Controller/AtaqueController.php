<?php

namespace Yacare\ZoonosisBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("ataque/")
 */
class AtaqueController extends \Yacare\BaseBundle\Controller\YacareAbmController
{
    use \Yacare\BaseBundle\Controller\ConEliminar;
}

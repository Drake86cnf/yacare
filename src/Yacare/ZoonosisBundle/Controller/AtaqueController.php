<?php

namespace Yacare\ZoonosisBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("ataque/")
 */
class AtaqueController extends \Tapir\BaseBundle\Controller\AbmController
{
    use \Yacare\BaseBundle\Controller\ConEliminar;
}

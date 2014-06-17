<?php

namespace Yacare\BromatologiaBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("actarutina/")
 */
class ActaRutinaController extends \Tapir\BaseBundle\Controller\AbmController
{
    use \Yacare\BaseBundle\Controller\ConEliminar;
}

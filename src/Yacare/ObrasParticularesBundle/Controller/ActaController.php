<?php
namespace Yacare\ObrasParticularesBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("actacontroller/")
 */
class ActaController extends \Tapir\BaseBundle\Controller\AbmController
{
    use \Tapir\BaseBundle\Controller\ConEliminar;
} 

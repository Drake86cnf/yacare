<?php
namespace Yacare\BromatologiaBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("vehiculo/")
 */
class VehiculoController extends \Tapir\BaseBundle\Controller\AbmController
{
    use\Tapir\BaseBundle\Controller\ConEliminar;
}

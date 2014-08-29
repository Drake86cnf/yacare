<?php
namespace Yacare\ComprasBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * @Route("licitacion/")
 */
class LicitacionController extends \Tapir\BaseBundle\Controller\AbmController
{
    use\Yacare\BaseBundle\Controller\ConImprimir;
    use\Tapir\BaseBundle\Controller\ConEliminar;
    use\Yacare\BaseBundle\Controller\ConQr;
}

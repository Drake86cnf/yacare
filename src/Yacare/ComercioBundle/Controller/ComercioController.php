<?php
namespace Yacare\ComercioBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Yacare\ComercioBundle\Entity\Actividad;

/**
 * Controlador de comercio.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 * @author Ezequiel Riquelme <rezequiel.tdf@gmail.com>
 * 
 * @Route("comercio/")
 */
class ComercioController extends \Tapir\AbmBundle\Controller\AbmController
{
    use \Tapir\AbmBundle\Controller\ConBuscar;

    /**
     * @Route("altamanual/")
     * @Template()
     */
    function altaManualAction(Request $request)
    {
        return $this->ArrastrarVariables($request);
    }
}

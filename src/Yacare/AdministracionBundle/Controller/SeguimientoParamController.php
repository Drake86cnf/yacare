<?php
namespace Yacare\AdministracionBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Controlador de parámetros de seguimiento.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 * 
 * @Route("seguimientoparam/")
 * @Security("has_role('ROLE_IDDQD')")
 */
class SeguimientoParamController extends \Tapir\AbmBundle\Controller\AbmController
{
}

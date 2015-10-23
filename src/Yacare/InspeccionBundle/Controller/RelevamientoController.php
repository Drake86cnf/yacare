<?php
namespace Yacare\InspeccionBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Controlador de relevamientos.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 *        
 * @Route("relevamiento/")
 */
class RelevamientoController extends \Tapir\AbmBundle\Controller\AbmController
{
    use \Tapir\AbmBundle\Controller\ConEliminar;
}

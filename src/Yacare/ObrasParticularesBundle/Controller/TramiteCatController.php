<?php
namespace Yacare\ObrasParticularesBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Controlador de trámites para certificados de aptitud técnica.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 * 
 * @Route("tramitecat/")
 */
class TramiteCatController extends \Yacare\TramitesBundle\Controller\TramiteController
{
    use \Tapir\AbmBundle\Controller\ConVer;
}

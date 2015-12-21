<?php
namespace Yacare\ObrasParticularesBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Controlador de movimientos de previas.
 * 
 * @author Ezequiel Riquelme <rezquiel.tdf@gmail.com>
 * 
 * @Route("previa/")
 */
class PreviaController extends \Tapir\AbmBundle\Controller\AbmController
{
    use \Tapir\AbmBundle\Controller\ConVer;
}

<?php

namespace Tapir\AyudaBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Controlador de ayuda.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 * 
 */
class AyudaController extends \Tapir\BaseBundle\Controller\BaseController
{
    use ConAyuda;
}
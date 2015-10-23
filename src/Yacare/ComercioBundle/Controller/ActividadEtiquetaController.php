<?php
namespace Yacare\ComercioBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Controlador de etiquetas de actividades.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 * @author Alejandro Díaz <alediaz.rc@gmail.com>
 * 
 * @Route("actividadetiqueta/")
 */
class ActividadEtiquetaController extends \Tapir\AbmBundle\Controller\AbmController
{
    use \Tapir\AbmBundle\Controller\ConEliminar;
    use \Tapir\AbmBundle\Controller\ConBuscar;

    function IniciarVariables()
    {
        parent::IniciarVariables();
        
        $this->BuscarPor = 'Nombre,Codigo';
    }
}

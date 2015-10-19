<?php
namespace Yacare\FlotaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Controlador de vehículos.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 *
 * @Route("vehiculo/")
 */
class VehiculoController extends \Tapir\BaseBundle\Controller\AbmController
{
    // use \Tapir\BaseBundle\Controller\ConBuscar;
    use \Tapir\BaseBundle\Controller\ConEliminar;

    function IniciarVariables()
    {
        parent::IniciarVariables();
        $this->BuscarPor = 'NumeroSerie, IdentificadorUnico, Marca, Modelo';
        $this->OrderBy = 'r.IdentificadorUnico';
    }
}

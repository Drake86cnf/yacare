<?php
namespace Yacare\FlotaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Controlador de vehículos.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 *
 * @Route("vehiculo/")
 */
class VehiculoController extends \Tapir\BaseBundle\Controller\AbmController
{
    use \Tapir\BaseBundle\Controller\ConEliminar;

    function IniciarVariables()
    {
        parent::IniciarVariables();
        $this->BuscarPor = 'NumeroSerie, IdentificadorUnico, Marca, Modelo';
        $this->OrderBy = 'r.IdentificadorUnico';
    }

    /**
     * @Route("listar/")
     * @Security("has_role('ROLE_FLOTA_ADMINISTRADOR') or has_role('ROLE_FLOTA_CARGA')")
     * @Template()
     */
    public function listarAction(Request $request)
    {
        return parent::listarAction($request);
    }

    /**
     * @Route("ver/")
     * @Security("has_role('ROLE_FLOTA_ADMINISTRADOR') or has_role('ROLE_FLOTA_CARGA')")
     * @Template()
     */
    public function verAction(Request $request)
    {
        return parent::verAction($request);
    }

    /**
     * @Route("editar/")
     * @Route("crear/")
     * @Security("has_role('ROLE_FLOTA_ADMINISTRADOR')")
     * @Template()
     */
    public function editarAction(Request $request)
    {
        return parent::editarAction($request);
    }
}

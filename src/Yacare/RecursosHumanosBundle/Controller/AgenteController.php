<?php
namespace Yacare\RecursosHumanosBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Controlador de agentes.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 *
 * @Route("agente/")
 */
class AgenteController extends \Tapir\BaseBundle\Controller\AbmController
{

    function IniciarVariables()
    {
        parent::IniciarVariables();

        $this->BuscarPor = 'id, p.NombreVisible, p.DocumentoNumero';
        if (in_array('r.Persona p', $this->Joins) == false) {
            $this->Joins[] = 'JOIN r.Persona p';
        }

        $this->OrderBy = 'p.NombreVisible';
    }

    /**
     * @Route("ver_datospersonales/")
     * @Template()
     */
    public function ver_datospersonalesAction(Request $request)
    {
        return $this->verAction($request);
    }

    /**
     * @Route("ver_lugardetrabajo/")
     * @Template()
     */
    public function ver_lugardetrabajoAction(Request $request)
    {
        return $this->verAction($request);
    }

    /**
     * @Route("ver_familiares/")
     * @Template()
     */
    public function ver_familiaresAction(Request $request)
    {
        return $this->verAction($request);
    }

    /**
     * @Route("ver/")
     * @Template()
     */
    public function verAction(Request $request)
    {
        $id = $this->ObtenerVariable($request, 'id');
        $res = parent::verAction($request);

        $res['tabs'] = $this->ObtenerPestanias($request, 'ver', $id);

        return $res;
    }

    /**
     * @Route("editar/")
     * @Template()
     */
    public function editarAction(Request $request)
    {
        $id = $this->ObtenerVariable($request, 'id');
        $res = parent::editarAction($request);

        $res['tabs'] = $this->ObtenerPestanias($request, 'editar');

        return $res;
    }

    /**
     * @Route("volcar/")
     * @Template("YacareRecursosHumanosBundle:Agente:listar.html.twig")
     */
    public function volcarAction(Request $request)
    {
        $id = $this->ObtenerVariable($request, 'id');
        $this->Paginar = false;

        if ($id) {
            $this->Where = 'r.id=' . $id;
        }
        $res = parent::listarAction($request);

        $ldap = new \Yacare\MunirgBundle\Helper\LdapHelper($this->container);

        $AgentesVolcados = array();
        foreach ($res['entities'] as $Agente) {
            if ($Agente->getPersona()->PuedeAcceder()) {
                $ldap->AgregarOActualizarAgente($Agente);
                $AgentesVolcados[] = $Agente;
            }
        }

        $res['entities'] = $AgentesVolcados;
        $ldap = null;

        return $res;
    }

    /**
     * Actualizo el servidor de dominio al editar el agente.
     */
    public function guardarActionPostPersist($entity, $editForm)
    {
        if ($entity->getId()) {
            $ldap = new \Yacare\MunirgBundle\Helper\LdapHelper($this->container);
            $ldap->AgregarOActualizarAgente($entity);
            $ldap = null;
        }
        return;
    }

    public function ObtenerPestanias($request, $actual, $id)
    {
        return new \Tapir\TemplateBundle\Controls\TabSet(
            array(
                new \Tapir\TemplateBundle\Controls\Tab('General',
                    $this->generateUrl($this->ObtenerRutaBase('ver'),
                        $this->ArrastrarVariables($request, array('id' => $id), false)), $actual == 'ver'),
                new \Tapir\TemplateBundle\Controls\Tab('Editar',
                    $this->generateUrl($this->ObtenerRutaBase('editar'),
                        $this->ArrastrarVariables($request, array('id' => $id), false)), $actual == 'editar')));
    }
}

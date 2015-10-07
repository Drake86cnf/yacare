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
     * @Route("ver_datospersonales/{id}/")
     * @Template()
     */
    public function ver_datospersonalesAction(Request $request, $id = null)
    {
        return $this->verAction($request, $id = null);
    }

    /**
     * @Route("ver_lugardetrabajo/{id}/")
     * @Template()
     */
    public function ver_lugardetrabajoAction(Request $request, $id = null)
    {
        return $this->verAction($request, $id = null);
    }

    /**
     * @Route("ver_familiares/{id}/")
     * @Template()
     */
    public function ver_familiaresAction(Request $request, $id = null)
    {
        return $this->verAction($request, $id = null);
    }

    /**
     * @Route("ver/{id}/")
     * @Template()
     */
    public function verAction(Request $request, $id = null)
    {
        $res = parent::verAction($request, $id);
        
        $res['tabs'] = $this->ObtenerPestanias($request, 'ver', $id);
        
        return $res;
    }

    /**
     * @Route("editar/{id}/")
     * @Template()
     */
    public function editarAction(Request $request, $id = null)
    {
        $res = parent::editarAction($request, $id);
        
        $res['tabs'] = $this->ObtenerPestanias($request, 'editar', $id);
        
        return $res;
    }

    /**
     * @Route("volcar/")
     * @Route("volcar/{id}/")
     * @Template("YacareRecursosHumanosBundle:Agente:listar.html.twig")
     */
    public function volcarAction(Request $request, $id = null)
    {
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

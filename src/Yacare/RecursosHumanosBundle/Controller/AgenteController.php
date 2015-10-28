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
 * @author Ezequiel Riquelme <rezequiel.tdf@gmail.com>
 *
 * @Route("agente/")
 */
class AgenteController extends \Tapir\AbmBundle\Controller\AbmController
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
        /*if ($entity->getId()) {
            $ldap = new \Yacare\MunirgBundle\Helper\LdapHelper($this->container);
            $ldap->AgregarOActualizarAgente($entity);
            $ldap = null;
        }*/
        return;
    }
    
    protected function guardarActionAfterSuccess(Request $request, $entity)
    {
        return $this->redirectToRoute($this->obtenerRutaBase('ver'),
            $this->ArrastrarVariables($request, array('id' => $entity->getId()), false));
    }
}

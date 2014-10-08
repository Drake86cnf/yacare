<?php
namespace Yacare\BaseBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Controlador de personas.
 *
 * @Route("persona/")
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class PersonaController extends \Tapir\BaseBundle\Controller\AbmController
{
    use\Tapir\BaseBundle\Controller\ConBuscar;
    Use\Tapir\BaseBundle\Controller\ConEliminar;
    Use\Tapir\BaseBundle\Controller\ConPerfil;

    function IniciarVariables()
    {
        parent::IniciarVariables();
        $this->BuscarPor = 'NombreVisible, Username, RazonSocial, DocumentoNumero, Cuilt, Email';
    }
    
    /**
     * Función para que las clases derivadas puedan intervenir la entidad después de guardar el perfil.
     */
    public function editarperfilActionPostPersist($entity, $editForm)
    {
        if($entity->getAgenteId()) {
            // Es un agente municipal, lo actualizo en el LDAP
            $em = $this->getDoctrine()->getManager();
            $Agente = $em->getRepository('Yacare\RecursosHumanosBundle\Entity\Agente')->find($entity->getAgenteId());
            
            $ldap = new \Yacare\MunirgBundle\Helper\LdapHelper();
            $ldap->AgregarOActualizarUsuario($Agente);
            $ldap = null;
        }
        return;
    }
    
    
    /**
     * Función para que las clases derivadas puedan intervenir la entidad después de cambiar la contraseña.
     */
    public function cambiarcontrasenaActionPostPersist($entity, $editForm)
    {
        if($entity->getAgenteId()) {
            // Es un agente municipal, lo actualizo en el LDAP
            $em = $this->getDoctrine()->getManager();
            $Agente = $em->getRepository('Yacare\RecursosHumanosBundle\Entity\Agente')->find($entity->getAgenteId());
        
            $ldap = new \Yacare\MunirgBundle\Helper\LdapHelper();
            $ldap->AgregarOActualizarUsuario($Agente);
            $ldap = null;
        }
        return;
    }
}

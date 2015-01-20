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
     * Actualizo el servidor de dominio al editar el perfil de usuario.
     */
    public function editarperfilActionPostPersist($entity, $editForm)
    {
        if($entity->getAgenteId()) {
            // Es un agente municipal, lo actualizo en el LDAP
            $em = $this->getDoctrine()->getManager();
            $Agente = $em->getRepository('Yacare\RecursosHumanosBundle\Entity\Agente')->find($entity->getAgenteId());
            
            $ldap = new \Yacare\MunirgBundle\Helper\LdapHelper();
            $ldap->AgregarOActualizarAgente($Agente);
            $ldap = null;
        }
        return;
    }
    
    
    /**
     * Actualizo el servidor de dominio al cambiar la contraseña.
     */
    public function cambiarcontrasenaActionPostPersist($entity, $editForm)
    {
        if($entity->getAgenteId()) {
            // Es un agente municipal, lo actualizo en el LDAP
            $em = $this->getDoctrine()->getManager();
            $Agente = $em->getRepository('Yacare\RecursosHumanosBundle\Entity\Agente')->find($entity->getAgenteId());
        
            $ldap = new \Yacare\MunirgBundle\Helper\LdapHelper();
            $ldap->CambiarContrasena($Agente);
            $ldap = null;
        }
        return;
    }
    
    
    /**
     * Muestra un formulario de consultas para buscar personas y ver sus datos.
     *
     * @Route("consultar/")
     * @Template()
     */
    public function consultarAction(Request $request)
    {
        $data = array();
        $res = array();
        
        $this->Paginar = false;
        $this->Limit = 50;
        
        $form = $this->createFormBuilder($data)
            ->add('filtro_buscar', 'text', array(
                'label' => 'Nombre o documento',
                'required' => false
            ))
            ->getForm();
    
        $form->handleRequest($request);
    
        if ($form->isValid()) {
            $data = $form->getData();
            $request->query->set('filtro_buscar', $data['filtro_buscar']);
            $reslistar = parent::listarAction($request);
            $res['entities'] = $reslistar['entities'];
        }
        
        $res['edit_form'] = $form->createView();
    
        return $this->ArrastrarVariables($res);
    }
    
    
    /**
     * Muestra un formulario para desduplicar dos personas (combinar registros duplicados).
     *
     * @Route("desduplicar/{id1}/{id2}")
     * @Template()
     */
    public function desduplicarAction(Request $request, $id1, $id2, $ok = 0)
    {
        if ($id1) {
            $entity1 = $this->obtenerEntidadPorId($id1);
        }
        
        if ($id2) {
            $entity2 = $this->obtenerEntidadPorId($id2);
        }
        
        if($ok) {
            
        }
   
        return $this->ArrastrarVariables(array(
            'entity1' => $entity1,
            'entity2' => $entity2
        ));
    }
}

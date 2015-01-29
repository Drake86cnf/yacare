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
        $this->ConservarVariables[] = 'campo';
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
     * @Route("modificardato/{id}")
     * @Template()
     */
    public function modificardatoAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        
        if ($id) {
            $entity = $this->obtenerEntidadPorId($id);
        }
        
        if (!$entity) {
            throw $this->createNotFoundException('No se puede encontrar la entidad.');
        }
        
        $campo = $request->query->get('campo');
        
        $editFormBuilder = $this->createFormBuilder($entity);
        
        switch($campo) {
            case 'Cuilt':
                $editFormBuilder->add($campo, 'text', array(
                    'label' => 'CUIL/CUIT',
                    'required' => true
                ));
                break;
            case 'Domicilio':
                $editFormBuilder->add($campo, 'text', array(
                    'label' => 'CUIL/CUIT',
                    'required' => true
                ));
                break;
            case 'TelefonoNumero':
                $editFormBuilder->add($campo, 'text', array(
                'label' => 'Teléfono',
                'required' => true
                ));
                $editFormBuilder->add('TelefonoVerificacionNivel', 'choice', array(
                    'choices' => array(
                        '0' => 'Sin confirmar',
                        '10' => 'Confirmado',
                        '20' => 'Cotejado',
                        '30' => 'Certificado'
                    ),
                    'label' => 'Nivel',
                    'required' => true
                ));
                break;
            case 'Email':
                $editFormBuilder->add($campo, 'text', array(
                    'label' => 'E-mail',
                    'required' => true
                ));
                $editFormBuilder->add($campo . 'VerificacionNivel', 'choice', array(
                    'choices' => array(
                        '0' => 'Sin confirmar',
                        '10' => 'Confirmado',
                        '20' => 'Cotejado',
                        '30' => 'Certificado'
                    ),
                    'label' => 'Nivel',
                    'required' => true,
                    'mapped' => false
                ));
                break;
        }
        
        $editForm = $editFormBuilder->getForm();
        $editForm->handleRequest($request);
        
        if ($editForm->isValid()) {
            echo '1';
            $em->persist($entity);
            $em->flush();
            return $this->redirect($this->generateUrl($this->obtenerRutaBase('ver'), $this->ArrastrarVariables(array('id' => $id), false)));
        } else {
            echo '2';
            echo get_class($editForm);
            $children = $editForm->all();
            foreach ($children as $child) {
                echo '5'. $child->getErrorsAsString();
            }
            
            $errors = $editForm->getErrors(true, true);
            //$errors = $this->get('validator')->validate($entity);
        }
        
        if ($errors) {
            echo '3' . $errors->count();
            foreach ($errors as $error) {
                $this->get('session')->getFlashBag()->add('danger', $error);
                echo '4' . $error->getMessage();
            }
        } else {
            $errors = null;
        }
            
        return $this->ArrastrarVariables(array(
            'edit_form' => $editForm->createView(),
            'entity' => $entity,
            'errors' => $errors
        ));
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

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
        
        $campoNombre = $this->ObtenerVariable($request, 'campo_nombre');
        
        $editFormBuilder = $this->createFormBuilder($entity);
        
        switch($campoNombre) {
            case 'Cuilt':
                $editFormBuilder->add($campoNombre, new \Tapir\BaseBundle\Form\Type\CuiltType(), array(
                    'label' => 'CUIL/CUIT',
                    'required' => true
                ));
                break;
            case 'DocumentoNumero':
                    $editFormBuilder->add($campoNombre, new \Yacare\BaseBundle\Form\Type\DocumentoType(), array(
                    'label' => 'Documento'
                ));
                break;
            case 'Domicilio':
                $editFormBuilder->add($campoNombre, new \Yacare\BaseBundle\Form\Type\DomicilioType(), array(
                    'label' => 'Domicilio',
                    'required' => true
                ));
                break;
            case 'TelefonoNumero':
                $editFormBuilder->add($campoNombre, 'text', array(
                    'label' => 'Teléfono(s)',
                    'required' => true
                ));
                $editFormBuilder->add('TelefonoVerificacionNivel', new \Tapir\BaseBundle\Form\Type\VerificacionNivelType(), array(
                    'label' => 'Nivel',
                    'required' => true
                ));
                break;
            case 'Email':
                $editFormBuilder->add($campoNombre, 'text', array(
                    'label' => 'E-mail',
                    'required' => true
                ));
                $editFormBuilder->add($campoNombre . 'VerificacionNivel', new \Tapir\BaseBundle\Form\Type\VerificacionNivelType(), array(
                    'label' => 'Nivel',
                    'required' => true
                ));
                break;
            case 'Pais':
                    $editFormBuilder->add('Pais', 'entity', array(
                        'label' => 'Nacionalidad',
                        'placeholder' => 'Sin especificar',
                        'class' => 'YacareBaseBundle:Pais',
                        'required' => false,
                        'preferred_choices' => $em->getRepository($this->CompleteEntityName)->findById(array(1, 2, 11, 15))
                    ));
                    break;
            case 'Genero':
                $editFormBuilder->add('Genero', new \Tapir\BaseBundle\Form\Type\GeneroType(), array(
                    'label' => 'Género',
                    'required' => true
                ));
                break;
        }
        
        $editForm = $editFormBuilder->getForm();
        $editForm->handleRequest($request);
        
        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            return $this->redirect($this->generateUrl($this->obtenerRutaBase('ver'), $this->ArrastrarVariables(array('id' => $id), false)));
        } else {
            $children = $editForm->all();
            foreach ($children as $child) {
                $child->getErrorsAsString();
            }
            
            $errors = $editForm->getErrors(true, true);
        }
        
        if ($errors) {
            foreach ($errors as $error) {
                $this->get('session')->getFlashBag()->add('danger', $error->getMessage());
            }
        } else {
            $errors = null;
        }
            
        return $this->ArrastrarVariables(array(
            'edit_form' => $editForm->createView(),
            'campo_nombre' => $campoNombre,
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

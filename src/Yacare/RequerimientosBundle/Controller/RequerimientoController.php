<?php
namespace Yacare\RequerimientosBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("requerimiento/")
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class RequerimientoController extends \Tapir\BaseBundle\Controller\AbmController
{
    use \Tapir\BaseBundle\Controller\ConBuscar;
    
    /**
     * @Route("ver/{id}")
     * @Template()
     */
    public function verAction(Request $request, $id = null)
    {
        $res = parent::verAction($request, $id);
    
        //$em = $this->getEm();
        $UsuarioConectado = $this->get('security.context')->getToken()->getUser();
        
        if( !is_string($UsuarioConectado)) {
            $NuevaNovedad = new \Yacare\RequerimientosBundle\Entity\Novedad();
            $NuevaNovedad->setRequerimiento($res['entity']);
            $NuevaNovedad->setUsuario($UsuarioConectado);
            $editForm = $this->createForm(new \Yacare\RequerimientosBundle\Form\NovedadType(), $NuevaNovedad);
            $res['form_novedad'] = $editForm->createView();
        }
    
        return $res;
    }
    
    
   
    
    /**
     * Intervengo el guardado para asignar el usuario creador y un encargado predeterminado encaso de que no tenga uno.
     */
    public function guardarActionPrePersist($entity, $editForm)
    {
        if((!$entity->getId())) {
            if(!$entity->getUsuario()) {
                $UsuarioConectado = $this->get('security.context')->getToken()->getUser();
                $entity->setUsuario($UsuarioConectado);
                $entity->setUsuarioNombre((string)$UsuarioConectado);
                $entity->setUsuarioEmail($UsuarioConectado->getEmail());
            }
            if($entity->getCategoria() && (!$entity->getEncargado())) {
                $entity->setEncargado($entity->getCategoria()->getEncargado());
            }
        }
        
        return parent::guardarActionPrePersist($entity, $editForm);
    }
    
    
    
    
    /**
     * Muestra un pequeño formulario para modificar un dato.
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
    
        if (! $entity) {
            throw $this->createNotFoundException('No se puede encontrar la entidad.');
        }
    
        $campoNombre = $this->ObtenerVariable($request, 'campo_nombre');
    
        $editFormBuilder = $this->createFormBuilder($entity);
    
        switch ($campoNombre) {
            case 'Estado':
                $editFormBuilder->add('Notas', null, array(
                        'label' => 'Descripción',
                        'required' => true))
                    ->add('Usuario', 'entity_hidden', array(
                        'class' => 'Yacare\BaseBundle\Entity\Persona'
                    ))
                    ->add('Requerimiento', 'entity_hidden', array(
                        'class' => 'Yacare\RequerimientosBundle\Entity\Requerimiento'
                    ));
                break;
            case 'DocumentoNumero':
                $editFormBuilder->add($campoNombre, new \Yacare\BaseBundle\Form\Type\DocumentoType(),
                array('label' => 'Documento'));
                break;
            case 'Domicilio':
                $editFormBuilder->add($campoNombre, new \Yacare\BaseBundle\Form\Type\DomicilioType(),
                array('label' => 'Domicilio','required' => true));
                break;
            case 'TelefonoNumero':
                $editFormBuilder->add($campoNombre, 'text', array('label' => 'Teléfono(s)','required' => true));
                $editFormBuilder->add('TelefonoVerificacionNivel',
                    new \Tapir\BaseBundle\Form\Type\VerificacionNivelType(),
                    array('label' => 'Nivel','required' => true));
                break;
            case 'Email':
                $editFormBuilder->add($campoNombre, 'text', array('label' => 'E-mail','required' => true));
                $editFormBuilder->add($campoNombre . 'VerificacionNivel',
                    new \Tapir\BaseBundle\Form\Type\VerificacionNivelType(),
                    array('label' => 'Nivel','required' => true));
                break;
            case 'Pais':
                $editFormBuilder->add('Pais', 'entity',
                array(
                'label' => 'Nacionalidad',
                'placeholder' => 'Sin especificar',
                'class' => 'YacareBaseBundle:Pais',
                'required' => false,
                'preferred_choices' => $em->getRepository($this->CompleteEntityName)
                ->findById(array(1,2,11,15))));
                break;
            case 'Genero':
                $editFormBuilder->add('Genero', new \Tapir\BaseBundle\Form\Type\GeneroType(),
                array('label' => 'Género','required' => true));
                break;
        }
    
        $editForm = $editFormBuilder->getForm();
        $editForm->handleRequest($request);
    
        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            return $this->redirect(
                $this->generateUrl($this->obtenerRutaBase('ver'), $this->ArrastrarVariables(array('id' => $id), false)));
        } else {
            $children = $editForm->all();
            foreach ($children as $child) {
                $child->getErrorsAsString();
            }
    
            $errors = $editForm->getErrors(true, true);
        }
    
        if ($errors) {
            foreach ($errors as $error) {
                $this->get('session')
                ->getFlashBag()
                ->add('danger', $error->getMessage());
            }
        } else {
            $errors = null;
        }
    
        return $this->ArrastrarVariables(
            array(
                'edit_form' => $editForm->createView(),
                'campo_nombre' => $campoNombre,
                'entity' => $entity,
                'errors' => $errors));
    }
}

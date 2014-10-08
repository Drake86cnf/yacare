<?php
namespace Tapir\BaseBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Trait para agregar a la entidad de usuario, para agregarle las funciones.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
trait ConPerfil
{

    /**
     * @Route("editarperfil/{id}", name="usuario_editarperfil", defaults={"id" = null})
     * @Route("editarperfil/", name="usuario_editarperfil_actual", defaults={"id" = null})
     * @Template()
     */
    public function editarperfilAction(Request $request, $id = null)
    {
        $entidadUsuario = $this->container->getParameter('tapir_usuarios_entidad');
        
        $em = $this->getDoctrine()->getManager();
        
        if ($id) {
            $entity = $em->getRepository($entidadUsuario)->find($id);
        } else {
            $user = $this->get('security.context')
                ->getToken()
                ->getUser();
            $entity = $em->getRepository($entidadUsuario)->find($user->getId());
        }
        
        if($entity->getUsername()) {
            $editForm = $this->createForm(new \Yacare\BaseBundle\Form\PersonaPerfilType(), $entity);
        } else {
            $editForm = $this->createForm(new \Yacare\BaseBundle\Form\PersonaPerfilCrearType(), $entity);
        }
        
        if ($request->getMethod() === 'POST') {
            $editForm->handleRequest($request);
            
            if ($editForm->isValid()) {
                echo '11111111111111111111111111111111';
                if ($entity->getPasswordEnc()) {
                    echo '22222222222222222222222222222222';
                    // Genero una nueva sal
                    $entity->setSalt(md5(uniqid(null, true)));
                
                    $factory = $this->get('security.encoder_factory');
                    $encoder = $factory->getEncoder($entity);
                    $encoded_password = $encoder->encodePassword($entity->getPasswordEnc(), $entity->getSalt());
                    $entity->setPassword($encoded_password);
                } else {
                    $entity->setPassword();
                }
                
                $em->persist($entity);
                $em->flush();
                
                $this->get('session')
                    ->getFlashBag()
                    ->add('success', 'Los cambios en "' . $entity . '" fueron guardados.');
                $errors = null;
            } else {
                $validator = $this->get('validator');
                $errors = $validator->validate($entity);
            }
            
            if ($errors) {
                foreach ($errors as $error) {
                    $this->get('session')
                    ->getFlashBag()
                    ->add('danger', $error);
                }
                
                $res = $this->ArrastrarVariables(array(
                    'entity' => $entity,
                    'errors' => $errors,
                    'create' => $id ? false : true,
                    'edit_form' => $editForm->createView()
                ));
                
                return $this->render('YacareBaseBundle:Persona:editarperfil.html.twig', $res);
            } else {
                $em->refresh($user); // Add this line
            }
        }

        return $this->ArrastrarVariables(array(
            'entity' => $entity,
            'edit_form_action' => 'usuario_editarperfil',
            'edit_form' => $editForm->createView()
        ));
    }

    /**
     * @Route("cambiarcontrasena/{id}", name="usuario_cambiarcontrasena", defaults={"id" = null})
     * @Route("cambiarcontrasena/", name="usuario_cambiarcontrasena_actual")
     * @Template()
     */
    public function cambiarContrasenaAction(Request $request, $id = null)
    {
        $terminado = 0;
        $entidadUsuario = $this->container->getParameter('tapir_usuarios_entidad');
        
        $em = $this->getDoctrine()->getManager();
        if ($id) {
            $entity = $em->getRepository($entidadUsuario)->find($id);
        } else {
            $user = $this->get('security.context')
                ->getToken()
                ->getUser();
            $entity = $em->getRepository($entidadUsuario)->find($user->getId());
        }
        
        $form = $this->createForm(new \Yacare\BaseBundle\Form\PersonaCambiarContrasenaType(), $entity);
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            // Guardo el password con hash
            if ($entity->getPasswordEnc()) {
                // Genero una nueva sal
                $entity->setSalt(md5(uniqid(null, true)));
                
                $factory = $this->get('security.encoder_factory');
                $encoder = $factory->getEncoder($entity);
                $encoded_password = $encoder->encodePassword($entity->getPasswordEnc(), $entity->getSalt());
                $entity->setPassword($encoded_password);
            } else {
                $entity->setPassword();
            }
            
            $terminado = 1;
            $em->persist($entity);
            $em->flush();
            
            return $this->redirect($this->generateUrl('logout'));
        }
        
        if (isset($user)) {
            $em->refresh($user);
        }
        
        return $this->ArrastrarVariables(array(
            'entity' => $entity,
            'edit_form' => $form->createView(),
            'terminado' => $terminado
        ));
    }
}

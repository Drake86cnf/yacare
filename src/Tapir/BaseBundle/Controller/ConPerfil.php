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
trait ConPerfil {

    /**
     * @Route("editarperfil/", name="usuario_editarperfil")
     * @Template()
     */
    public function editarperfilAction(Request $request)
    {
        $entidadUsuario = $this->container->getParameter('tapir_usuarios_entidad');

        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.context')->getToken()->getUser();
        $entity = $em->getRepository($entidadUsuario)->find($user->getId());
        
        $form = $this->createForm(new \Yacare\BaseBundle\Form\PersonaPerfilType(), $entity);

        if ($request->getMethod() === 'POST') {
            $form->bindRequest($request);

            if ($form->isValid()) {
                $em->persist($entity);
                $em->flush();

                return $this->redirect($this->generateUrl('editarperfil/'));
            }

            $em->refresh($user); // Add this line
        }

        return $this->ArrastrarVariables(array(
            'entity'      => $entity,
            'edit_form'   => $form->createView(),
        ));
    
        //parent::__editarAction($id);
    }
    
    
    /**
     * @Route("cambiarcontrasena/", name="usuario_cambiarcontrasena")
     * @Template()
     */
    public function cambiarContrasenaAction(Request $request)
    {
        $terminado = 0;
        $entidadUsuario = $this->container->getParameter('tapir_usuarios_entidad');
        
        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.context')->getToken()->getUser();
        $entity = $em->getRepository($entidadUsuario)->find($user->getId());
        
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

        $em->refresh($user);

        return $this->ArrastrarVariables(array(
            'entity'      => $entity,
            'edit_form'   => $form->createView(),
            'terminado'   => $terminado,
        ));
    }
}

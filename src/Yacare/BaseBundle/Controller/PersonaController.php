<?php

namespace Yacare\BaseBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("persona/")
 */
class PersonaController extends YacareAbmController
{
    Use \Yacare\BaseBundle\Controller\ConEliminar;
    
    function __construct() {
        $this->BuscarPor = 'NombreVisible, Username, RazonSocial, DocumentoNumero, Cuilt, Email';
        parent::__construct();
    }
    
    
    /**
     * @Route("editarperfil/")
     * @Template()
     */
    public function editarperfilAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.context')->getToken()->getUser();
        $entity = $em->getRepository('YacareBaseBundle:Persona')->find($user->getId());
        
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
     * @Route("cambiarcontrasena/")
     * @Template()
     */
    public function cambiarContrasenaAction(Request $request)
    {
        $terminado = 0;
        
        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.context')->getToken()->getUser();
        $entity = $em->getRepository('YacareBaseBundle:Persona')->find($user->getId());
        
        $form = $this->createForm(new \Yacare\BaseBundle\Form\PersonaCambiarContrasenaType(), $entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            // Guardo el password con hash
            if($entity->getPasswordEnc()) {
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

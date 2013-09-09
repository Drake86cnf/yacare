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
        $this->BuscarPor = 'NombreVisible';
        parent::__construct();
    }
    
    
    /**
     * @Route("editarperfil/")
     * @Template()
     */
    public function editarperfilAction()
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.context')->getToken()->getUser();
        $entity = $em->getRepository('YacareBaseBundle:Persona')->find($user->getId());
        
        $form = $this->createForm(new \Yacare\BaseBundle\Form\PersonaPerfilType(), $entity);

        $request = $this->getRequest();

        if ($request->getMethod() === 'POST') {
            $form->bindRequest($request);

            if ($form->isValid()) {
                $em->persist($entity);
                $em->flush();

                return $this->redirect($this->generateUrl('editarperfil/'));
            }

            $em->refresh($user); // Add this line
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $form->createView(),
        );
    
        parent::__editarAction($id);
    }
}

<?php

namespace Yacare\BaseBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends YacareBaseController
{
    function __construct() {
        parent::__construct();

        $this->MenuOpciones = array(
            'Inicio' => '/inicio',
        );
    }
    
    /**
     * @Route("/")
     * @Template
     */
    public function inicioAction()
    {
        return $this->ArrastrarVariables(array(
            'opciones' => $this->MenuOpciones
        ));
    }
    
    /**
     * @Route("/logout", name="logout")
     * @Template
     */
    public function logoutAction()
    {
        return array();
    }

    
    /**
     * @Route("/login", name="login")
     * @Template
     */
    public function loginAction(Request $request)
    {
        $session = $request->getSession();

        // get the login error if there is one
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(
                SecurityContext::AUTHENTICATION_ERROR
            );
        } else {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        }

        return array(
                // last username entered by the user
                'last_username' => $session->get(SecurityContext::LAST_USERNAME),
                'error'         => $error,
            );
    }
}

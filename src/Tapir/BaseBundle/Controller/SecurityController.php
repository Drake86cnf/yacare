<?php
namespace Tapir\BaseBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Controlador de inicio y cierre de sesión.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class SecurityController extends Controller
{
    /**
     * @Route("login")
     * @Template
     */
    public function loginAction(Request $request)
    {
        $session = $request->getSession();
        
        // get the login error if there is one
        if ($request->attributes->has(Security::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(Security::AUTHENTICATION_ERROR);
        } else {
            $error = $session->get(Security::AUTHENTICATION_ERROR);
            $session->remove(Security::AUTHENTICATION_ERROR);
        }
        return array(
            'last_username' => $session->get(Security::LAST_USERNAME), // last username entered by the user 
            'error' => $error);
    }

    /**
     * @Route("logout", name="logout")
     * @Template
     */
    public function logoutAction()
    {
        return array();
    }
}

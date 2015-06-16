<?php
namespace Indepnet\GlpiBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("ticket/")
 */
class TicketController extends \Tapir\BaseBundle\Controller\AbmController
{
    function IniciarVariables()
    {
        $this->EmName = 'glpi';
        
        parent::IniciarVariables();
        
        $this->Joins[] = 'JOIN r.Users tu';
        $this->Joins[] = 'JOIN tu.User u';
    }
    
    
    /**
     * @Route("listar/")
     * @Template()
     */
    public function listarAction(Request $request)
    {
        $User = $this->getEm()->getRepository('Indepnet\GlpiBundle\Entity\User')
            ->findBy(array( 'Name' => $this->get('security.token_storage')->getToken()->getUser()->getUsername() ));
        
        if(count($User) == 1) {
            $User = $User[0];
        }
        
        if (! isset($this->Where)) {
            $this->Where = "u.id=" . $User->getId();
        }
        
        $this->OrderBy = 'r.DateMod DESC';
        
        return parent::listarAction($request);
    }
}

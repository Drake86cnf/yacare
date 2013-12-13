<?php

namespace Yacare\TramitesBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("asociacionrequisito/")
 */
class AsociacionRequisitoController extends \Yacare\BaseBundle\Controller\YacareAbmController
{
    use \Yacare\BaseBundle\Controller\ConEliminar;
    
    public function __construct() {
        parent::__construct();
        $this->ConservarVariables = array('parent_id');
        $this->Paginar = false;
    }
    
    /**
     * @Route("listar/")
     * @Template()
     */
    public function listarAction(Request $request) {
        $parent_id = $request->query->get('parent_id');

        if($parent_id) {
            $em = $this->getDoctrine()->getManager();
            $parent_id = $request->query->get('parent_id');
            $TramiteTipo = $em->getReference('YacareTramitesBundle:TramiteTipo', $parent_id);

            $this->Where .= " AND r.TramiteTipo=$parent_id";
        }
        
        $res = parent::listarAction($request);
        
        if($parent_id) {
            $res['parent'] = $TramiteTipo;
        }
        
        return $res;
    }
    
    /**
     * @Route("editar/{id}")
     * @Route("crear/")
     * @Template()
     */
    public function editarAction($id = null)
    {
        $res = parent::editarAction($id);
        
        if($id === null) {
            // En caso de crear uno nuevo, le asigno el parent predeterminado
            $em = $this->getDoctrine()->getManager();
            $parent_id = $request->query->get('parent_id');
            $TramiteTipo = $em->getReference('YacareTramitesBundle:TramiteTipo', $parent_id);
            $res['entity']->setTramiteTipo($TramiteTipo);
        }
        
        return $res;
    }
}

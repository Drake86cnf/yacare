<?php

namespace Yacare\BaseBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("comentario/")
 */
class ComentarioController extends YacareAbmController
{
    function __construct() {
        $this->BundleName = 'Base';
        $this->EntityName = 'Comentario';
        parent::__construct();
    }
    
    
    /**
     * @Route("listar/")
     * @Template()
     */
    function listarAction() {
        $request = $this->getRequest();
        $entidadTipo = $request->query->get('et');
        $entidadId = $request->query->get('eid');
        
        if($entidadTipo) {
            $this->Where .= " AND r.EntidadTipo='$entidadTipo'";
            if($entidadId)
                $this->Where .= " AND r.EntidadId=$entidadId";
            
            $res = parent::listarAction();
            return $res;
        } else {
            return null;
        }
    }
}

<?php

namespace Yacare\TramitesBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("tramiterequisito/")
 */
class TramiteRequisitoController extends \Yacare\BaseBundle\Controller\YacareBaseController
{
    use \Yacare\BaseBundle\Controller\ConEliminar;
    
    public function __construct() {
        $this->BundleName = 'Tramites';
        $this->EntityName = 'TramiteRequisito';
        $this->ConservarVariables = array ('tramite_id');
        $this->Paginar = false;
        parent::__construct();
    }
    
    /**
     * @Route("listar/")
     * @Template()
     */
    function listarAction() {
        $request = $this->getRequest();
        $tramite_id = $request->query->get('tramite_id');
        
        if($tramite_id)
            $this->Where .= " AND r.Tramite='$tramite_id'";
        
        $res = parent::listarAction();
        
        return $res;
    }
}

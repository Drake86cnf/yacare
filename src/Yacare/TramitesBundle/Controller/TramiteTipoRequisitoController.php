<?php

namespace Yacare\TramitesBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("tramitetiporequisito/")
 */
class TramiteTipoRequisitoController extends \Yacare\BaseBundle\Controller\YacareAbmController
{
    use \Yacare\BaseBundle\Controller\ConEliminar;
    
    public function __construct() {
        parent::__construct();
        $this->ConservarVariables = array ('tramitetipo_id');
        $this->Paginar = false;
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

<?php

namespace Tapir\BaseBundle\Controller;

use Symfony\Component\HttpFoundation\Request;

trait ConBuscar {
    /**
     * @Route("buscar/")
     * @Template()
     */
    public function buscarAction(Request $request)
    {
        return $this->ArrastrarVariables(array(
        ));
    }
    
    
    /**
     * @Route("buscarresultados/")
     * @Template()
     */
    public function buscarresultadosAction(Request $request)
    {
        $this->Paginar = false;
        $this->Limit = 500;
        return $this->listarAction($request);
    }
}
<?php

namespace Yacare\BaseBundle\Controller;

use Symfony\Component\HttpFoundation\Request;

trait ConBuscar {
    /**
     * @Route("buscar/")
     * @Template()
     */
    public function buscarAction()
    {
        return $this->ArrastrarVariables(array(
        ));
    }
    
    
    /**
     * @Route("buscarresultados/")
     * @Template()
     */
    public function buscarresultadosAction()
    {
        $this->Paginar = false;
        $this->Limit = 500;
        return $this->listarAction();
    }
}
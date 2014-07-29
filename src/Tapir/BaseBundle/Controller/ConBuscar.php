<?php

namespace Tapir\BaseBundle\Controller;

use Symfony\Component\HttpFoundation\Request;

/**
 * Trait que agrega la capacidad de brindar un buscador.
 * 
 * Para ello se deben también implementar las plantillas "buscar" y 
 * "buscarresultados".
 * 
 * @author Ernesto Carrea <equistango@gmail.com>
 */
trait ConBuscar {
    /**
     * Acción de mostrar el buscador.
     * 
     * @see buscarresultadosAction()
     * 
     * @Route("buscar/")
     * @Template()
     */
    public function buscarAction(Request $request)
    {
        return $this->ArrastrarVariables(array(
        ));
    }
    
    
    /**
     * Acción de mostrar los resultados de la búsqueda.
     * 
     * @see buscarAction()
     * 
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
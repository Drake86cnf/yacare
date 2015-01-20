<?php
namespace Tapir\BaseBundle\Controller;

use Symfony\Component\HttpFoundation\Request;

/**
 * Agrega la capacidad de brindar un buscador.
 *
 * Para ello se deben implementar las vistas "buscar" y "buscarresultados"
 * para la entidad que este controlador controla.
 *
 * @author Ernesto Carrea <equistango@gmail.com>
 */
trait ConBuscar
{

    /**
     * Acción de mostrar el buscador.
     *
     * @see buscarresultadosAction() 
     * @Route("buscar/")
     * @Template()
     */
    public function buscarAction(Request $request)
    {
        return $this->ArrastrarVariables(array());
    }

    /**
     * Acción de mostrar los resultados de la búsqueda.
     *
     * @see buscarAction()
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
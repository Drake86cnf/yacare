<?php
namespace Tapir\BaseBundle\Controller;

use Symfony\Component\HttpFoundation\Request;

/**
 * Agrega la capacidad de brindar un buscador.
 *
 * Para ello se deben implementar las vistas "buscar" y "buscarresultados"
 * para la entidad que este controlador controla.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
trait ConBuscar
{
    /**
     * Acción de mostrar el buscador.
     *
     * @Route("buscar/")
     * @Template()
     */
    public function buscarAction(Request $request)
    {
        $this->Paginar = false;
        $this->Limit = 500;
        $buscar = $this->ObtenerVariable($request, 'buscar');
        $filtro_buscar = $this->ObtenerVariable($request, 'filtro_buscar');
        if ($buscar || $filtro_buscar) {
			// Si hay texto de búsqueda, derivo a buscar
			return $this->listarAction($request);
        } else {
            // Si no hay texto de búsqueda, devuelvo una respuesta vacía
            return $this->ArrastrarVariables($request, array());
        }
    }
}

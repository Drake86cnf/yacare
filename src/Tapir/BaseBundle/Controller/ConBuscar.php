<?php
namespace Tapir\BaseBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

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
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @Sensio\Bundle\FrameworkExtraBundle\Configuration\Route("buscar/")
     * @Sensio\Bundle\FrameworkExtraBundle\Configuration\Template()
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


    /**
     * @Route("buscarjson/")
     * @Template()
     */
    public function buscarjsonAction(Request $request)
    {
        $request->query->set('filtro_buscar', $this->ObtenerVariable($request, 'q'));

        $res = $this->buscarAction($request);

        $jsonres = array();
        if(array_key_exists('entities', $res)) {
            foreach ($res['entities'] as $entity) {
                $jsonres[] = array(
                    'id' => $entity->getId(),
                    'text' => (string)$entity
                );
            }
        }

        $ret = array();
        $ret['results'] = $jsonres;

        $response = new \Symfony\Component\HttpFoundation\Response(json_encode($ret,  JSON_PRETTY_PRINT));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}

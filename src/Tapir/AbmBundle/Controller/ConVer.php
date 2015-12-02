<?php
namespace Tapir\AbmBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Agrega la accion de ver.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
trait ConVer {
    /**
     * Ver una entidad.
     *
     * Es como editar, pero sólo lectura.
     *
     * @see editarAction() editarAction()
     *
     * @Route("ver/")
     * @Template()
     */
    public function verAction(Request $request)
    {
        $id = $this->ObtenerVariable($request, 'id');
    
        if ($id) {
            $entity = $this->ObtenerEntidadPorId($id);
        }
    
        if (! $entity) {
            throw $this->createNotFoundException('No se puede encontrar la entidad.');
        }
    
        $res = $this->ConstruirResultado(new \Tapir\AbmBundle\Helper\Resultados\ResultadoVerAction($this), $request);
        $res->Entidad = $entity;
    
        return array('res' => $res);
    }
}
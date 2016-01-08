<?php
namespace Yacare\CatastroBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Controlador para calles.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 * 
 * @Route("calle/")
 */
class CalleController extends \Tapir\AbmBundle\Controller\AbmController
{
    use \Yacare\BaseBundle\Controller\ConExportarLista;
    
    /**
     * Actualiza el campo UbicacionFecha a la fecha actual.
     *
     * @Route("actualizarfechaubicacion/")
     */
    public function actualizarfechaubicacionAction(Request $request)
    {
        $em = $this->getEm();
        $id = $this->ObtenerVariable($request, 'id');
        $entity = $this->ObtenerEntidadPorId($id);
        $entity->setUbicacionFecha(new \DateTime());
        $em->persist($entity);
        $em->flush();
        
        return $this->redirectToRoute($this->obtenerRutaBase('listar'), $this->ArrastrarVariables($request, null, false));
    }
}

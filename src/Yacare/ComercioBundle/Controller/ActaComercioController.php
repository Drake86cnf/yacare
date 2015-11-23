<?php
namespace Yacare\ComercioBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Controlador de actas de comercio.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 * 
 * @Route("actacomercio/")
 */
class ActaComercioController extends \Tapir\AbmBundle\Controller\AbmController
{
    protected function CrearNuevaEntidad(Request $request)
    {
        $em = $this->getEm();
        $entidad = parent::CrearNuevaEntidad($request);
        
        $ComercioId = $this->ObtenerVariable($request, 'comercio');
        if($ComercioId > 0) {
            $entidad->setComercio($em->getReference('YacareComercioBundle:Comercio', $ComercioId));
        }
        
        return $entidad;
    }
} 

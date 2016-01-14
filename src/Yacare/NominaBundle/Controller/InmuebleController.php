<?php
namespace Yacare\NominaBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Tapir\OsmBundle\Maps;

/**
 * Controlador de inmuebles.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 * 
 * @Route("inmueble/")
 */
class InmuebleController extends \Tapir\AbmBundle\Controller\AbmController
{
use \Tapir\AbmBundle\Controller\ConVer {
        \Tapir\AbmBundle\Controller\ConVer::verAction as parent_verAction;
    }
    
    /**
     * @Route("ver/")
     * @Template()
     */
    public function verAction(Request $request)
    {
        $ResultadoVer = $this->parent_verAction($request);
        $res = $ResultadoVer['res'];
        $Inmueble = $res->Entidad;
        if(!$Inmueble->getUbicacion()) {
            $em = $this->getEm();
            $Helper = new \Yacare\CatastroBundle\Helper\PartidaHelper($this->container, $em);
            $Helper->ObtenerUbicacionPorDomicilio($Inmueble);
            $em->flush();
        }
    
        if($Inmueble->getUbicacion()) {
            // Creo un mapa con la ubicación
            $Mapa = new Maps\Map();
            $Marcador = new Maps\Marker();
            $Marcador->setPosition(new Maps\Point($Inmueble->getUbicacion()->getX(), $Inmueble->getUbicacion()->getY()));
            $Marcador->setDescription($Inmueble->getDomicilioReal());
            $Mapa->addMarker($Marcador);
            $res->Mapa = $Mapa;
        }
        return $ResultadoVer;
    }
    
    
    /**
     * @Route("publica/ver/")
     * @Template("YacareNominaBundle:Inmueble:publica/ver.html.twig")
     */
    public function publica_verAction(Request $request)
    {
        return $this->parent_verAction($request);
    }
}

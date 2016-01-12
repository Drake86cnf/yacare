<?php
namespace Yacare\NominaBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use \Tapir\OsmBundle\Maps;
use \Tapir\OsmBundle\Render;

/**
 * Controlador de rastreadores GPS.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 * @author Ezequiel Riquelme <rezequiel.tdf@gmail.com>
 *
 * @Route("dispositivorastreadorgps/")
 */
class DispositivoRastreadorGpsController extends DispositivoController
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
        
        if ($res->Entidad->getObs() == null) {
            $res->Entidad->setObs('Serie ' . $res->Entidad->getNumeroSerie());
        }
        
        $em = $this->getEm();
        $UltimoRastreo = $em->getRepository('Yacare\NominaBundle\Entity\DispositivoRastreo')->findBy(
            array('Dispositivo' => $res->Entidad->getId()), array('id' => 'DESC'), 1);
        
        if (count($UltimoRastreo) == 1) {
            // Si es un array de un 1 elemento, lo convierto en un elemento plano.
            $UltimoRastreo = $UltimoRastreo[0];
        }
        $res->UltimoRastreo = $UltimoRastreo;
        
        $Mapa = new Maps\Map();
        
        if ($UltimoRastreo) {
            $Mapa->addMarker($this->CrearMarcador($UltimoRastreo, $res->Entidad));
            $Mapa->setCenter(new Maps\Point($UltimoRastreo->getUbicacion()->getX(), $UltimoRastreo->getUbicacion()->getY()));
        } else {
            $Mapa->setCenter(new Maps\Point(-53.789858, -67.692911));
        }
        
        $UltimosRastreos = $em->getRepository('Yacare\NominaBundle\Entity\DispositivoRastreo')->findBy(
            array('Dispositivo' => $res->Entidad->getId()), array('id' => 'DESC'), 100);
        
        if ($UltimosRastreos) {
            $polyline = new Maps\Polyline();
            
            //$polyline->setOption('strokeColor', '#ff0000');
            //$polyline->setOption('strokeOpacity', '0.3');
            
            foreach ($UltimosRastreos as $Rastreo) {
                $polyline->addPoint(new Maps\Point($Rastreo->getUbicacion()->getX(), $Rastreo->getUbicacion()->getY()));
            }
            
            $Mapa->addPolyline($polyline);
        }
        
        $res->Mapa = $Mapa;
        
        return $ResultadoVer;
    }

    /**
     * @Route ("coordjson/")
     */
    public function coordjsonAction(Request $request)
    {
        // Obtenemos los ids de los marcadores enviados por POST
        $rastreadores = $request->request->get('id_ras');
        $x = array();
        $y = array();
        
        $em = $this->getEm();
        
        // Iteramos por cada marcador en el mapa y buscamos las nuevas coordenadas
        foreach ($rastreadores as $rastreador) {
            $UltimoRastreo = $em->getRepository('Yacare\NominaBundle\Entity\DispositivoRastreo')->findBy(
                array('Dispositivo' => $rastreador), array('id' => 'DESC'), 1);
            
            if (count($UltimoRastreo) == 1) {
                // Si es un array de un 1 elemento, lo convierto en un elemento plano.
                $UltimoRastreo = $UltimoRastreo[0];
            }
            // TODO: quitar el rand para producción
            $sumX = $UltimoRastreo->getUbicacion()->getX();
            $sumY = $UltimoRastreo->getUbicacion()->getY();
            
            // Asignamos las coordenadas en dos array X e Y
            array_push($x, $sumX);
            array_push($y, $sumY);
        }
        $res = array('x' => $x, 'y' => $y);
        
        /*
         * En este punto sabemos que al marcador[0] le corresponden las coordenadas x[0] e y[0]
         * y asi con todos
         */
        return new JsonResponse($res);
    }

    /**
     * @Route ("vertodos/")
     * @Template("YacareBaseBundle:DispositivoRastreadorGps:ver.html.twig")
     */
    public function vertodosAction(Request $request)
    {
        $res = $this->ConstruirResultado(new \Tapir\AbmBundle\Helper\Resultados\ResultadoActionAbmController($this), $request);
        
        $em = $this->getEm();
        $Dispositivos = $em->getRepository('Yacare\NominaBundle\Entity\DispositivoRastreadorGps')->findAll();
        
        $Mapa = new Maps\Map();
        
        foreach ($Dispositivos as $Dispositivo) {
            $id = $Dispositivo->getId();
            $entity = $this->ObtenerEntidadPorId($id);
            
            if ($entity->getObs() == null) {
                $entity->setObs('Serie ' . $entity->getNumeroSerie());
            }
            $UltimoRastreo = $em->getRepository('Yacare\NominaBundle\Entity\DispositivoRastreo')->findBy(
                array('Dispositivo' => $id), array('id' => 'DESC'), 1);
            
            if ($UltimoRastreo) {
                $UltimoRastreo = $UltimoRastreo[0];
                $Mapa->addMarker($this->CrearMarcador($UltimoRastreo, $entity));
            }
        }
        
        $res->Dispositivos = $Dispositivos;
        $res->Mapa = $Mapa;
       
        return $this->ArrastrarVariables($request, array('res' => $res));
    }

    
    /**
     * Rutina que crea un marcador en base a las coordenadas pasadas como parametros.
     *
     * La rutina crea primero una "infoWindow" y realiza los distintos 'set' añadiendo las opciones con la cual trabajará.
     * Luego realiza las mismas operaciones de configuración a un 'marker', que será el marcador que apuntará en el
     * mapa a al último rastreo de un dispositivo GPS.
     *
     * @param \Yacare\NominaBundle\Entity\DispositivoRastreo       $UltimoRastreo última coordenada del GPS estudiado.
     * @param \Yacare\NominaBundle\Entity\DispositivoRastreadorGps $entity        el dispositivo GPS.
     * @return \Marker
     */
    private function CrearMarcador($UltimoRastreo, $entity)
    {
        $Marcador = new Maps\Marker();
        $Marcador->setPosition(new Maps\Point($UltimoRastreo->getUbicacion()->getX(), $UltimoRastreo->getUbicacion()->getY()));
        $Marcador->setDescription($entity);
        return $Marcador;
        
        $infoWindow = new \Ivory\GoogleMap\Overlays\InfoWindow();
        
        // Configuración de las opciones de "Info Window"
        $infoWindow->setPrefixJavascriptVariable('info_window_');
        $infoWindow->setPosition(0, 0, true);
        $infoWindow->setPixelOffset(1.1, 2.1, 'px', 'pt');
        $infoWindow->setContent($entity->getObs());
        $infoWindow->setOpen(true);
        $infoWindow->setAutoClose(false);
        $infoWindow->setOptions(array('disableAutoPan' => false, 'zIndex' => 10, 'maxWidth' => 100));
    }
}

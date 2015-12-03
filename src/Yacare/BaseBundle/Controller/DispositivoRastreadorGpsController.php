<?php
namespace Yacare\BaseBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Ivory\GoogleMap\Helper\MapHelper;

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
        $res = $this->parent_verAction($request);
        
        if ($res['res']->Entidad->getObs() == null) {
            $res['res']->Entidad->setObs('Serie ' . $res['res']->Entidad->getNumeroSerie());
        }
        
        $em = $this->getEm();
        $UltimoRastreo = $em->getRepository('Yacare\BaseBundle\Entity\DispositivoRastreo')->findBy(
            array('Dispositivo' => $res['res']->Entidad->getId()), array('id' => 'DESC'), 1);
        
        if (count($UltimoRastreo) == 1) {
            // Si es un array de un 1 elemento, lo convierto en un elemento plano.
            $UltimoRastreo = $UltimoRastreo[0];
        }
        $res['ultimo_rastreo'] = $UltimoRastreo;
        
        $Mapa = $this->CrearMapa();
        
        if ($UltimoRastreo) {
            $Mapa->addMarker($this->CrearMarcador($UltimoRastreo, $res['res']->Entidad));
        } else {
            $Mapa->setCenter(- 53.789858, - 67.692911, true);
        }
        
        $UltimosRastreos = $em->getRepository('Yacare\BaseBundle\Entity\DispositivoRastreo')->findBy(
            array('Dispositivo' => $res['res']->Entidad->getId()), array('id' => 'DESC'), 100);
        
        if ($UltimosRastreos) {
            $polyline = new \Ivory\GoogleMap\Overlays\Polyline();
            
            $polyline->setOption('strokeColor', '#ff0000');
            $polyline->setOption('strokeOpacity', '0.3');
            
            foreach ($UltimosRastreos as $Rastreo) {
                $polyline->addCoordinate($Rastreo->getUbicacion()->getX(), $Rastreo->getUbicacion()->getY(), true);
            }
            
            $Mapa->addPolyline($polyline);
        }
        $MapHelper = new MapHelper();
        $MapHelper->setExtensionHelper('gps_extension_helper', 
            new \Yacare\BaseBundle\Resources\Extensions\GpsExtensionHelper());
        
        $JavaScriptMapa = $MapHelper->renderJavascripts($Mapa);
        
        $res['mapa'] = $Mapa;
        $res['js_mapa'] = $JavaScriptMapa;
        
        return $res;
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
            $UltimoRastreo = $em->getRepository('Yacare\BaseBundle\Entity\DispositivoRastreo')->findBy(
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
        $em = $this->getEm();
        $Dispositivos = $em->getRepository('Yacare\BaseBundle\Entity\DispositivoRastreadorGps')->findAll();
        
        $Mapa = $this->CrearMapa();
        
        foreach ($Dispositivos as $Dispositivo) {
            $id = $Dispositivo->getId();
            $entity = $this->ObtenerEntidadPorId($id);
            
            if ($entity->getObs() == null) {
                $entity->setObs('Serie ' . $entity->getNumeroSerie());
            }
            $UltimoRastreo = $em->getRepository('Yacare\BaseBundle\Entity\DispositivoRastreo')->findBy(
                array('Dispositivo' => $id), array('id' => 'DESC'), 1);
            
            if ($UltimoRastreo) {
                $UltimoRastreo = $UltimoRastreo[0];
                $Mapa->addMarker($this->CrearMarcador($UltimoRastreo, $entity));
            }
        }
        $MapHelper = new MapHelper();
        $MapHelper->setExtensionHelper('gps_extension_helper', 
            new \Yacare\BaseBundle\Resources\Extensions\GpsExtensionHelper());
        
        $JavaScriptMapa = $MapHelper->renderJavascripts($Mapa);
        
        return $this->ArrastrarVariables($request, 
            array('dispositivos' => $Dispositivos, 'mapa' => $Mapa, 'js_mapa' => $JavaScriptMapa));
    }

    /**
     * Rutina que crea un mapa base de GoogleMaps.
     *
     * @return \Map
     */
    private function CrearMapa()
    {
        $Mapa = $this->get('ivory_google_map.map');
        
        $Mapa->setMapOption('zoom', 30);
        $Mapa->setAsync(true);
        $Mapa->setAutoZoom(true);
        $Mapa->setMapOptions(
            array('disableDefaultUI' => true, 'disableDoubleClickZoom' => true, 'mapTypeId' => 'roadmap'));
        $Mapa->setStylesheetOptions(array('width' => '100%', 'height' => '480px'));
        $Mapa->setLanguage('es');
        
        return $Mapa;
    }

    /**
     * Rutina que crea un marcador en base a las coordenadas pasadas como parametros.
     *
     * La rutina crea primero una "infoWindow" y realiza los distintos 'set' añadiendo las opciones con la cual trabajará.
     * Luego realiza las mismas operaciones de configuración a un 'marker', que será el marcador que apuntará en el
     * mapa a al último rastreo de un dispositivo GPS.
     *
     * @param \Yacare\BaseBundle\Entity\DispositivoRastreo       $UltimoRastreo última coordenada del GPS estudiado.
     * @param \Yacare\BaseBundle\Entity\DispositivoRastreadorGps $entity        el dispositivo GPS.
     * @return \Marker
     */
    private function CrearMarcador($UltimoRastreo, $entity)
    {
        $infoWindow = new \Ivory\GoogleMap\Overlays\InfoWindow();
        
        // Configuración de las opciones de "Info Window"
        $infoWindow->setPrefixJavascriptVariable('info_window_');
        $infoWindow->setPosition(0, 0, true);
        $infoWindow->setPixelOffset(1.1, 2.1, 'px', 'pt');
        $infoWindow->setContent($entity->getObs());
        $infoWindow->setOpen(true);
        $infoWindow->setAutoClose(false);
        $infoWindow->setOptions(array('disableAutoPan' => false, 'zIndex' => 10, 'maxWidth' => 100));
        
        // Configuración de las opciones del marcador a incorporar
        $marker = new \Ivory\GoogleMap\Overlays\Marker();
        
        $marker->setPosition($UltimoRastreo->getUbicacion()->getX(), $UltimoRastreo->getUbicacion()->getY(), true);
        $marker->setAnimation(\Ivory\GoogleMap\Overlays\Animation::DROP);
        $marker->setOptions(array('clickable' => true, 'flat' => true, 'title' => (string) $entity));
        
        // Incorporo la ventana de información como una propiedad más al marcador.
        $marker->setInfoWindow($infoWindow);
        
        return $marker;
    }
}

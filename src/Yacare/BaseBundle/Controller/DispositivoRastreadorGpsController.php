<?php
namespace Yacare\BaseBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Ivory\GoogleMapBundle\Model\MapTypeId;
use Ivory\GoogleMap\Helper\Extension;
use Ivory\GoogleMap\Helper\MapHelper;
use Yacare\BaseBundle\Resources\Extensions\GpsExtensionHelper;

/**
 * Controlador de rastreadores GPS.
 *
 * @Route("dispositivorastreadorgps/")
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class DispositivoRastreadorGpsController extends DispositivoController
{

    /**
     * @Route("ver/{id}")
     * @Template()
     */
    public function verAction(Request $request, $id = null)
    {
        $res = parent::verAction($request, $id);
        
        $entity = $res['entity'];
        
        if ($entity->getObs() == null) {
            $entity->setObs('Serie ' . $entity->getNumeroSerie());
        }
        
        $em = $this->getEm();
        $UltimoRastreo = $em->getRepository('Yacare\BaseBundle\Entity\DispositivoRastreo')->findBy(
            array('Dispositivo' => $id), array('id' => 'DESC'), 1);
        
        if (count($UltimoRastreo) == 1) {
            // Si es un array de un 1 elemento, lo convierto en un elemento plano.
            $UltimoRastreo = $UltimoRastreo[0];
        }
        $res['ultimorastreo'] = $UltimoRastreo;
        
        $map = $this->CrearMapa();
        
        if ($UltimoRastreo) {
            $map->addMarker($this->CrearMarcador($UltimoRastreo, $entity));
        } else {
            $map->setCenter(- 53.789858, - 67.692911, true);
        }
        
        $UltimosRastreos = $em->getRepository('Yacare\BaseBundle\Entity\DispositivoRastreo')->findBy(
            array('Dispositivo' => $id), array('id' => 'DESC'), 100);
        
        if ($UltimosRastreos) {
            $polyline = new \Ivory\GoogleMap\Overlays\Polyline();
            
            $polyline->setOption('strokeColor', '#ff0000');
            $polyline->setOption('strokeOpacity', '0.3');
            
            foreach ($UltimosRastreos as $Rastreo) {
                $polyline->addCoordinate($Rastreo->getUbicacion()
                    ->getX(), $Rastreo->getUbicacion()
                    ->getY(), true);
            }
            
            $map->addPolyline($polyline);
        }
        
        
        $mapHelper = new MapHelper();
        
        $mapHelper->setExtensionHelper('gps_extension_helper', new GpsExtensionHelper());
        
        $output = $mapHelper->renderJavascripts($map);
        
        
        $res['map'] = $map;
        $res['js'] = $output;
        $res['id'] = $id;
        $res['uno'] = true;
        
        return $res;
    }

    /**
     * @Route ("coordjson/")
     */
    public function coordjsonAction(Request $request)
    {
    	
    	
        //obtenemos los ids de los marcadores enviados por POST
    	$rastreadores = $request->request->get('id_ras');
        	
    	
    	
    	$x = array();
    	
    	$y = array();
    	
    	$em = $this->getEm();
    	
    	
    	//iteramos por cada marcador en el mapa y buscamos las nuevas coordenadas
    	foreach ($rastreadores as $rastreador){
    	
    		$UltimoRastreo = $em->getRepository('Yacare\BaseBundle\Entity\DispositivoRastreo')->findBy(
    				array('Dispositivo' => $rastreador), array('id' => 'DESC'), 1);
    		
    		if (count($UltimoRastreo) == 1) {
    			// Si es un array de un 1 elemento, lo convierto en un elemento plano.
    			$UltimoRastreo = $UltimoRastreo[0];
    		}


		//TODO: quitar el rand para produccion    		
    		$sumX = $UltimoRastreo->getUbicacion()->getX() + (rand(0,10)/100);
    		
    		$sumY = $UltimoRastreo->getUbicacion()->getY() + (rand(0,10)/100);
    		
    		//asignamos las coordenadas en dos array X e Y
    		array_push($x, $sumX);
    		
    		array_push($y, $sumY);
    	}
    	
        
        $res = array('x' => $x,'y' => $y);
        
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
        
        $map = $this->CrearMapa();
        
        foreach ($Dispositivos as $Dispositivo) {
            $id = $Dispositivo->getId();
            $res = parent::verAction($request, $id);
            $entity = $res['entity'];
            
            if ($entity->getObs() == null) {
                $entity->setObs('Serie ' . $entity->getNumeroSerie());
            }
            
            $UltimoRastreo = $em->getRepository('Yacare\BaseBundle\Entity\DispositivoRastreo')->findBy(
                array('Dispositivo' => $id), array('id' => 'DESC'), 1);
            
            if ($UltimoRastreo) {
                $UltimoRastreo = $UltimoRastreo[0];
                $map->addMarker($this->CrearMarcador($UltimoRastreo, $entity));
                
                // $map->setCenter($UltimoRastreo->getUbicacion()->getX(), $UltimoRastreo->getUbicacion()->getY(), true);
            }
        }
        
        $mapHelper = new MapHelper();
        
        $mapHelper->setExtensionHelper('gps_extension_helper', new GpsExtensionHelper());
        
        $output = $mapHelper->renderJavascripts($map);
        
        $res['dispositivos'] = $Dispositivos;
        $res['js'] = $output;
        $res['map'] = $map;
        $res['uno'] = false;
        
        return $res;
    }

    /**
     * Rutina que crea un mapa base de GoogleMaps.
     */
    private function CrearMapa()
    {
        $map = $this->get('ivory_google_map.map');
        
        
        $map->setMapOption('zoom', 30);
        $map->setAsync(true);
        $map->setAutoZoom(true);
        
        $map->setMapOptions(
            array('disableDefaultUI' => true,'disableDoubleClickZoom' => true,'mapTypeId' => 'roadmap'));
        
        $map->setStylesheetOptions(array('width' => '100%','height' => '480px'));
        
        $map->setLanguage('es');
        
        return $map;
    }

    /**
     * Rutina que crea un marcador en base a las coordenadas pasadas como parametros.
     *
     * La rutina crea primero una "infoWindow" y realiza los distintos 'set' añadiendo las opciones con la cual trabajará.
     * Luego realiza las mismas operaciones de configuración a un 'marker', que será el marcador que apuntará en el mapa a al último rastreo de un dispositivo GPS.
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
        // $infoWindow->setAutoOpen(true);
        // $infoWindow->setOpenEvent(\Ivory\GoogleMap\Events\MouseEvent::CLICK);
        $infoWindow->setAutoClose(false);
        $infoWindow->setOptions(
            array('disableAutoPan' => false,'zIndex' => 10,'maxWidth' => 100));
        
        // Configuración de las opciones del marcador a incorporar
        $marker = new \Ivory\GoogleMap\Overlays\Marker();
        
        $marker->setPosition($UltimoRastreo->getUbicacion()
            ->getX(), $UltimoRastreo->getUbicacion()
            ->getY(), true);
        $marker->setAnimation(\Ivory\GoogleMap\Overlays\Animation::DROP);
        $marker->setOptions(
            array('clickable' => true,'flat' => true,'title' => (string) $entity));
        
        // Incorporo la ventana de información como una propiedad más al marcador.
        $marker->setInfoWindow($infoWindow);
        
        return $marker;
    }
}

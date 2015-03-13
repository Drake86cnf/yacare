<?php
namespace Yacare\BaseBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Ivory\GoogleMapBundle\Model\MapTypeId;

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
    
        $em = $this->getEm();
        $UltimoRastreo = $em->getRepository('Yacare\BaseBundle\Entity\DispositivoRastreo')
            ->findBy( array ( 'Dispositivo' => $id ), array('id' => 'DESC'), 1 );
        
        if(count($UltimoRastreo) == 1) {
            // Si es un array de un 1 elemento, lo convierto en un elemento plano.
            $UltimoRastreo = $UltimoRastreo[0];
        }
        $res['ultimorastreo'] = $UltimoRastreo;
        
        $map = $this->get('ivory_google_map.map');
        
        
        //$map->setMapOption('zoom', 3);
        $map->setAsync(true);
        $map->setAutoZoom(true);
        
        $map->setMapOptions(array(
            'disableDefaultUI'       => true,
            'disableDoubleClickZoom' => true
        ));
        
        $map->setStylesheetOptions(array(
            'width'  => '100%',
            'height' => '480px'
        ));
        
        $map->setLanguage('es');
        
        if($UltimoRastreo) {
            $map->setCenter($UltimoRastreo->getUbicacion()->getX(), $UltimoRastreo->getUbicacion()->getY(), true);
            
            $marker = new \Ivory\GoogleMap\Overlays\Marker();
            
            $marker->setPosition($UltimoRastreo->getUbicacion()->getX(), $UltimoRastreo->getUbicacion()->getY(), true);
            $marker->setAnimation(\Ivory\GoogleMap\Overlays\Animation::DROP);
            
            $marker->setOption('clickable', false);
            $marker->setOption('flat', true);
            
            // Add your marker to the map
            $map->addMarker($marker);
        } else {
            $map->setCenter(-53.789858, -67.692911, true);
        }
        
        $UltimosRastreos = $em->getRepository('Yacare\BaseBundle\Entity\DispositivoRastreo')
            ->findBy( array ( 'Dispositivo' => $id ), array('id' => 'DESC'), 100 );
        
        if($UltimosRastreos) {
            $polyline = new \Ivory\GoogleMap\Overlays\Polyline();
            
            $polyline->setOption('strokeColor', '#ff0000');
            $polyline->setOption('strokeOpacity', '0.3');
            
            foreach ($UltimosRastreos as $Rastreo) {
                $polyline->addCoordinate($Rastreo->getUbicacion()->getX(), $Rastreo->getUbicacion()->getY(), true);
            }
            
            $map->addPolyline($polyline);
        }
        
        $res['map'] = $map;
    
        return $res;
    }
    
    /**
     * @Route ("vertodos/")
     * @Template()
     */
    public function vertodosAction (Request $request) 
    {
    	//$res = parent::listarAction($request);
    	$em = $this->getEm();
    	$Dispositivos = $em->getRepository('Yacare\BaseBundle\Entity\DispositivoRastreadorGps')
    		->findAll();
    	
    	$map = $this->get('ivory_google_map.map');
    	
    	//$map->setMapOption('zoom', 3);
    	$map->setAsync(true);
    	$map->setAutoZoom(true);
    	
    	$map->setMapOptions(array(
    			'disableDefaultUI'       => true,
    			'disableDoubleClickZoom' => true
    	));
    	
    	$map->setStylesheetOptions(array(
    			'width'  => '100%',
    			'height' => '480px'
    	));
    	
    	$map->setLanguage('es');
    	
    	foreach ($Dispositivos as $Dispositivo) {
    		$id = $Dispositivo->getId();
    		$UltimoRastreo = $em->getRepository('Yacare\BaseBundle\Entity\DispositivoRastreo')
            	->findBy( array ( 'Dispositivo' => $id ), array('id' => 'DESC'), 1 ); 
    		
    		if($UltimoRastreo) {
    			//$map->setCenter($UltimoRastreo->getUbicacion()->getX(), $UltimoRastreo->getUbicacion()->getY(), true);
    			$UltimoRastreo = $UltimoRastreo[0];
    			$marker = new \Ivory\GoogleMap\Overlays\Marker();
    		
    			$marker->setPosition($UltimoRastreo->getUbicacion()->getX(), $UltimoRastreo->getUbicacion()->getY(), true);
    			$marker->setAnimation(\Ivory\GoogleMap\Overlays\Animation::DROP);
    		
    			$marker->setOption('clickable', false);
    			$marker->setOption('flat', true);
    		
    			// Add your marker to the map
    			$map->addMarker($marker); 
    		}
    	}
    	
    	$res['map'] = $map;
    	
    	return $res;
    }
}

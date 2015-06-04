<?php

namespace Yacare\BaseBundle\Resources\Extensions;

use Ivory\GoogleMap\Helper\Extension\ExtensionHelperInterface;
use Ivory\GoogleMap\Map;

class GpsExtensionHelper implements ExtensionHelperInterface
{
	/**
	 * @inheritdoc
	 */
	public function renderLibraries(Map $map)
	{
		return null;
	}
	
	/**
	 * @inheritdoc
	 */
	public function renderBefore(Map $map)
	{
		return null;
	}
	
	/**
	 * @inheritdoc
	 */
	public function renderAfter(Map $map)
	{
		//Obtengo todos los marcadores del mapa
		$markers = $map->getMarkers();
		
		$mapVar = $map->getJavaScriptVariable();
		
		$polylines = $map->getPolylines();
		
		$polyVars = array();
		
		//Obtengo las variables (String) de cada uno de los marcadores y se almacenan en un array. 
		$variables = array();
		
		foreach ($markers as $mark){
			$variable = $mark->getJavaScriptVariable();
			array_push($variables, $variable);
		}
		
		//Obtengo las variables de las polylines.
		foreach ($polylines as $polyline){
			array_push($polyVars, $polyline->getJavaScriptVariable());
		}
		
		//Guardo las variables en String $ret, para ser el retorno del metodo
		$ret = 'markers = new Array(); map = ' . $mapVar . ';' . ' polylines = new Array();';
		$i = 0;
		
		foreach($variables as $variable){
			$ret = $ret . 'markers['. $i .'] = ' . $variable . ';' . PHP_EOL;
			$i++;
		}
		
		$i = 0;
		foreach($polyVars as $polyline){
			$ret = $ret . 'polylines['. $i .'] = ' . $polyline . ';' . PHP_EOL;			
		}
		
		return $ret;
	}
	

}
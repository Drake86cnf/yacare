<?php
namespace Tapir\OsmBundle\Twig;

use Twig_Extension;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Tapir\OsmBundle\Maps;

class OsmExtension extends \Twig_Extension
{
    protected $container;
    
    public function __construct(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
    
    public function getFunctions() {
        return array(
            new \Twig_SimpleFunction('osm_renderjs', array($this,'osm_renderjs'), array('is_safe' => array('html'))),
            new \Twig_SimpleFunction('osm_quickmapjs', array($this,'osm_quickmapjs'), array('is_safe' => array('html')))
        );
    }
    
    public function osm_quickmapjs($location, $description, $divid = null) {
        if(!$divid) {
            $divid = 'map';
        }
        
        $Map = new Maps\Map();
        $Marker = new Maps\Marker();
        $Marker->setPosition(new Maps\Point($location));
        $Marker->setDescription($description);
        $Map->addMarker($Marker);
        
        return $this->osm_renderjs($Map, $divid);
    }
    
    public function osm_renderjs($map, $divid = null, $renderer = null) {
        if(!$divid) {
            $divid = 'map';
        }
        
        if(!$renderer) {
            $renderer = new \Tapir\OsmBundle\Render\Leaflet($this->container);
        }
        
        $renderer->setDivId($divid); 
        $renderer->setMap($map);
        
        return $renderer->RenderJs();
    }
    
    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'osm_extension';
    }
}

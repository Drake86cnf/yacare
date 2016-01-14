<?php
namespace Yacare\CatastroBundle\Helper;

use Doctrine\ORM\Event\LifecycleEventArgs;

/**
 * Maneja los eventos "lyfecycle" para actuar ante cambios en las partidas.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class PartidaHelper extends \Yacare\BaseBundle\Helper\Helper
{
    function __construct($listener = null, $em = null)
    {
        parent::__construct($listener, $em);
    }

    public function PreUpdatePersist($entidad, $args = null)
    {
        // Nada
    }
    
    /**
     * Obtiene las coordenadas de una partida desde su domicilio, desde servicios de GeoCoding.
     *
     * @param  $elementoConUbicacion Un elemento que debe tener los traits ConUbicacion y ConDomicilioLocal
     */
    public function ObtenerUbicacionPorDomicilio($elementoConUbicacion)
    {
        if(!$elementoConUbicacion->getUbicacion()
            && ((!$elementoConUbicacion->getUbicacionFecha()) || $elementoConUbicacion->getUbicacionFecha()->diff(new \DateTime())->days > 30)) {
                // No tiene ubicación y nunca se consultó o se consultó hace más de 30 días.
                $Domicilio = new \Tapir\OsmBundle\GeoCoding\Address(
                    $elementoConUbicacion->getDomicilioNumero(),
                    $elementoConUbicacion->getDomicilioCalle()->getNombre(),
                    'Río Grande',
                    null,
                    'Tierra del Fuego',
                    'AR'
                    );
                
                $Punto = $this->ObtenerUbicacionPorDireccion($Domicilio);
                // Busco la ubicación en un servicio de GeoCoding y la guardo
                if($Punto) {
                    $elementoConUbicacion->setUbicacion($Punto);
                }
                // Actualizo la fecha de la última consulta de ubicación, aunque ésta no haya devuelto datos
                $elementoConUbicacion->setUbicacionFecha(new \DateTime());
                $this->em->persist($elementoConUbicacion);
            }
    }
    
    
    /**
     * Obtiene las coordenadas de una partida desde su domicilio, desde servicios de GeoCoding.
     *
     * @param  \Yacare\CatastroBundle\Entity\Partida $elementoConUbicacion
     */
    public function ObtenerUbicacionPorDireccion($Domicilio)
    {
        // Busco la ubicación en un servicio de GeoCoding y la guardo
        $GeoLocService = $this->container->get('tapirosmbundle.geocoding.nominatim');
        $DatosGeo = $GeoLocService->GetCoordinateFromAddress($Domicilio);
        if(!$DatosGeo) {
            // Pruebo con GoogleMaps
            $GeoLocService = $this->container->get('tapirosmbundle.geocoding.googlemaps');
            $DatosGeo = $GeoLocService->GetCoordinateFromAddress($Domicilio);
        }
        if($DatosGeo) {
            $Punto = new \CrEOF\Spatial\PHP\Types\Geometry\Point($DatosGeo->getX(), $DatosGeo->getY());
            return $Punto;
        }
        
        return null;
    }
}

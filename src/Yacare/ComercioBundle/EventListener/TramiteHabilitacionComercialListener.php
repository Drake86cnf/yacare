<?php
namespace Yacare\ComercioBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\Common\EventSubscriber;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use Yacare\ComercioBundle\Entity\ITramiteHabilitacionComercial;

/**
 * Escucha los eventos "lifecycle" de Doctrine para intervenir durante la creación o modificación de un Trámite de
 * Habilitación Comercial.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class TramiteHabilitacionComercialListener implements EventSubscriber
{
    private $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function preUpdate(LifecycleEventArgs $args)
    {}

    /**
     * Interviene en la creación de un trámite de habilitación comercial.
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        if ($entity instanceof ITramiteHabilitacionComercial) {
            $em = $args->getManager();
            
            $Comercio = $entity->getComercio();
            if (! $Comercio->getTitular()) {
                // Si el comercio no tiene un titular, le asigno el mismo titular que el trámite de habilitación
                $Comercio->setTitular($entity->getTitular());
                // También el apoderado
                $Comercio->setApoderado($entity->getApoderado());
                
                // Consolidar las actividades para que no queden campos en blanco
                \Yacare\ComercioBundle\Controller\ComercioController::ReordenarActividades($Comercio);
            }
            
            // Obtengo el CPU correspondiente a la actividad, para la cantidad de m2 de este local
            $Local = $Comercio->getLocal();
            if ($Local && $entity->getUsoSuelo() == null) {
                // $Superficie = $Local->getSuperficie();
                $Actividad = $Comercio->getActividad1();
                
                // Busco el uso del suelo para esa zona
                $UsoSuelo = $em->createQuery(
                    'SELECT u FROM Yacare\CatastroBundle\Entity\UsoSuelo u
                    WHERE u.Codigo=:codigo AND u.SuperficieMaxima<:sup
                    ORDER BY u.SuperficieMaxima DESC')
                    ->setParameter('codigo', $Actividad->getCodigoCpu())
                    ->setParameter('sup', $Local->getSuperficie())
                    ->setMaxResults(1)
                    ->getResult();
                // Si es un array tomo el primero
                if ($UsoSuelo && count($UsoSuelo) > 0) {
                    $UsoSuelo = $UsoSuelo[0];
                }
                
                if ($UsoSuelo) {
                    $Partida = $Local->getPartida();
                    if ($Partida) {
                        $Zona = $Partida->getZona();
                        if ($Zona) {
                            $entity->setUsoSuelo($UsoSuelo->getUsoZona($Zona->getId()));
                        }
                    }
                }
            }            
            $entity->setNombre('Trámite de habilitación de ' . $Comercio->getNombre());
        }
    }

    public function getSubscribedEvents()
    {
        return [\Doctrine\ORM\Events::prePersist, \Doctrine\ORM\Events::preUpdate];
    }
}

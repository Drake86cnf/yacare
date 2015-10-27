<?php
namespace Yacare\ComercioBundle\Helper;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;


/**
 * Maneja los eventos "lyfecycle" para actuar ante ciertos cambios en los trámites de habilitación comercial.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class TramiteHabilitacionComercialHelper extends \Yacare\BaseBundle\Helper\Helper
{
    function __construct($em = null) {
        parent::__construct($em);
    }
    
    public function PreUpdatePersist($tramite, $args = null) {
        $Comercio = $tramite->getComercio();
        
        if (! $Comercio->getTitular()) {
            // Si el comercio no tiene un titular, le asigno el mismo titular que el trámite de habilitación
            $Comercio->setTitular($tramite->getTitular());
            // También el apoderado
            $Comercio->setApoderado($tramite->getApoderado());
        
            $this->em->persist($Comercio);
        }
        
        // Consolidar las actividades para que no queden campos en blanco
        \Yacare\ComercioBundle\Controller\ComercioController::ReordenarActividades($Comercio);
        
        $Local = $Comercio->getLocal();
        
        // TODO: obtener el peor uso de suelo para las actividades
        if ($Local && $tramite->getUsoSuelo() == null) {
            // Obtengo el CPU correspondiente a la actividad, para la cantidad de m2 de este local
            $Actividad = $Comercio->getActividad1();
        
            // Busco el uso del suelo para esa zona
            $UsoSuelo = $this->em->createQuery(
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
                                        $tramite->setUsoSuelo($UsoSuelo->getUsoZona($Zona->getId()));
                                    }
                                }
                            }
                             
        }
        $tramite->setNombre('Trámite de habilitación de ' . $Comercio->getNombre());
    }
}

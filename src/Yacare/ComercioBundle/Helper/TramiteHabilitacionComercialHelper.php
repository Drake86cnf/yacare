<?php
namespace Yacare\ComercioBundle\Helper;

/**
 * Maneja los eventos "lyfecycle" para actuar ante ciertos cambios en los trámites de habilitación comercial.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class TramiteHabilitacionComercialHelper extends \Yacare\BaseBundle\Helper\Helper
{
    function __construct($listener = null, $em = null)
    {
        parent::__construct($listener, $em);
    }

    public function PreUpdatePersist($tramite, $args = null)
    {
        $Comercio = $tramite->getComercio();
        
        if ($Comercio) {
            if (! $Comercio->getTitular()) {
                // Si el comercio no tiene un titular, le asigno el mismo titular que el trámite de habilitación
                $Comercio->setTitular($tramite->getTitular());
                
                // También el apoderado
                $Comercio->setApoderado($tramite->getApoderado());
                
                $this->em->persist($Comercio);
            }
            
            $Local = $Comercio->getLocal();
            
            // Actualizo el uso de suelo para el trámite
            if ($Local) {
                if ($Local && $Local->getPartida()) {
                    $tramite->setUsoSuelo(
                        $this->ObtenerPeorUsoSuelo($Local->getPartida()
                            ->getZona(), $Comercio->getActividades()));
                }
            }            
            $tramite->setNombre('Trámite de habilitación de ' . $Comercio->getNombre());
        } else {
            $tramite->setNombre('Trámite de habilitación');
        }
    }

    /**
     * Obtiene el peor uso de suelo para un conjunto de actividades en una zona determinada.
     * 
     * Se llama el peor uso de suelo al uso de suelo más restrictivo.
     * 
     * @param Yacare\CatastroBundle\Entity\Zona $Zona
     * @param Yacare\ComercioBundle\Entity\Actividad[] $Actividades
     */
    public function ObtenerPeorUsoSuelo($Zona, $Actividades)
    {
        $UsosSuelo = $this->em->createQuery(
            'SELECT u FROM Yacare\CatastroBundle\Entity\UsoSuelo u WHERE u.SuperficieMaxima=0')->getResult();
        
        $PeorUsoSuelo = 0;
        if ($Zona) {
            // Recorrer las actividades en buscar del peor uso de suelo
            foreach ($Actividades as $Actividad) {
                $CodigoCpu = $Actividad->getCodigoCpu();
                if ($CodigoCpu) {
                    foreach ($UsosSuelo as $UsoSuelo) {
                        if ($UsoSuelo->getCodigo() == $CodigoCpu) {
                            $Uso = $UsoSuelo->getUsoZona($Zona->getId());
                            if ($Uso > $PeorUsoSuelo) {
                                $PeorUsoSuelo = $Uso;
                            }
                        }
                    }
                }
            }
        }        
        return $PeorUsoSuelo;
    }
}

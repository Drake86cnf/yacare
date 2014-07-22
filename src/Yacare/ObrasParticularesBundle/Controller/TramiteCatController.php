<?php

namespace Yacare\ObrasParticularesBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("tramitecat/")
 */
class TramiteCatController extends \Yacare\TramitesBundle\Controller\TramiteController
{
    public function EmitirComprobante($tramite) {
        
        $Comprob = parent::EmitirComprobante($tramite);
        
        $Comprob->setLocal($tramite->getLocal());
        $Comprob->setTitular($tramite->getTitular());
       
        return $Comprob;
    }


    public function guardarActionPrePersist($entity, $editForm) {
        $em = $this->getDoctrine()->getManager();

        $res = parent::guardarActionPrePersist($entity, $editForm);
        
        //$entity->setTitular($this->getPartida()->getTitular());

        $Actividad = $entity->getActividadPrincipal();

        // Busco el uso del suelo para esa zona
        $UsoSuelo = $em->createQuery('SELECT u FROM Yacare\CatastroBundle\Entity\UsoSuelo u WHERE u.Codigo=:codigo AND u.SuperficieMaxima<:sup ORDER BY u.SuperficieMaxima DESC')
                ->setParameter('codigo', $Actividad->getCodigoCpu())
                ->setParameter('sup', $entity->getLocal()->getSuperficie())
                ->setMaxResults(1)
                ->getResult();
        // Si es un array tomo el primero
        if($UsoSuelo && count($UsoSuelo) > 0) {
            $UsoSuelo = $UsoSuelo[0];
        }

        if($UsoSuelo) {
            $Partida = $entity->getLocal()->getPartida();
            if($Partida) {
                $Zona = $Partida->getZona();
                if($Zona) {
                    $entity->setUsoSuelo($UsoSuelo->getUsoZona($Zona->getId()));
                }
            }
        }
        
        $entity->setNombre('Trámite de CAT de ' . $entity->getTitular());

        return $res;
    }
}

<?php

namespace Yacare\TramitesBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("tramite/")
 */
class TramiteController extends \Yacare\BaseBundle\Controller\YacareAbmController
{
    function __construct() {
        parent::__construct();
        $this->ConservarVariables[] = 'parent_id';
    }
    
    public function guardarActionPrePersist($entity) {
        $this->AsociarEstadosRequisitos($entity, null, $entity->getTramiteTipo()->getAsociacionRequisitos());
    }
    
    protected function AsociarEstadosRequisitos($entity, $EstadoRequisitoPadre, $Asociaciones) {
        // Crear (en cero) los estados de los requisitos asociados a este trámite.
        foreach($Asociaciones as $AsociacionRequisito) {
            // Primero busco para ver si ya existe
            $EstadoRequisito = null;
            foreach($entity->getEstadosRequisitos() as $EstReq) {
                if($EstReq->getAsociacionRequisito() === $AsociacionRequisito) {
                    // Ya existe, por lo tanto no lo agrego
                    $EstadoRequisito = $EstReq;
                    break;
                }
            }

            if($EstadoRequisito == null) {
                // No existe, así que la creo
                $EstadoRequisito = new \Yacare\TramitesBundle\Entity\EstadoRequisito();
                $EstadoRequisito->setEstado(0);
                $EstadoRequisito->setTramite($entity);
            }
            
            $EstadoRequisito->setAsociacionRequisito($AsociacionRequisito);
            $EstadoRequisito->setEstadoRequisitoPadre($EstadoRequisitoPadre);

            if(!$EstadoRequisito->getId()) {
                $entity->AgregarEstadoRequisito($EstadoRequisito);
            }
            
            if($AsociacionRequisito->getRequisito()->getTipo() == 'tra') {
                // Es un trámite... asocio los sub-requisitos
                $SubTramiteTipo = $AsociacionRequisito->getRequisito()->getTramiteTipoEspejo();
                if($SubTramiteTipo) {
                    $this->AsociarEstadosRequisitos($entity, $EstadoRequisito, $SubTramiteTipo->getAsociacionRequisitos());
                }
            }
        }
    }
}

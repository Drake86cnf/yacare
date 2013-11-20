<?php

namespace Yacare\TramitesBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("tramite/")
 */
class TramiteController extends \Yacare\BaseBundle\Controller\YacareAbmController
{
    function __construct() {
        parent::__construct();
        $this->ConservarVariables[] = 'parent_id';
    }
    
    /**
     * @Route("terminar/{id}")
     * @Template()
     */
    public function terminarAction($id = null)
    {
        $em = $this->getDoctrine()->getManager();
        
        $entity = $em->getRepository('Yacare' . $this->BundleName . 'Bundle:' . $this->EntityName)->find($id);
        $entity->setEstado(100);
        
        $Comprob = $this->EmitirComprobante($entity);
        if($Comprob) {
            $Comprob->setTramiteOrigen($entity);
            $Comprob->setNumero($this->ObtenerProximoNumeroComprobante($Comprob));
            $em->persist($Comprob);
        }
        
        $em->persist($entity);
        $em->flush();
        
        return $this->ArrastrarVariables(array(
            'entity' => $entity,
            'comprob' => $Comprob
        ));
    }
    
    public function EmitirComprobante($tramite) {
        return null;
    }
    
    public function ObtenerProximoNumeroComprobante($comprob) {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery('SELECT MAX(c.Numero) FROM \Yacare\TramitesBundle\Entity\Comprobante c WHERE c.ComprobanteTipo=?1 AND c.NumeroPrefijo=?2');
        $query->setParameter(1, $comprob->getComprobanteTipo());
        $query->setParameter(2, $comprob->getNumeroPrefijo());
        $res = (int)$query->getResult(\Doctrine\ORM\Query::HYDRATE_SINGLE_SCALAR);
        return ++$res;
    }
    
    
    public function guardarActionPrePersist($entity) {
        $res = parent::guardarActionPrePersist($entity);
        
        if(!$entity->getTramiteTipo()) {
            // La propiedad TramiteTipo está en blanco... es normal al crear un trámite nuevo
            // Busco el TramiteTipo que corresponde a la clase y lo guardo
            $em = $this->getDoctrine()->getManager();
            
            $NombreClase = '\\' . get_class($entity);
            $TramiteTipo = $em->getRepository('YacareTramitesBundle:TramiteTipo')->findOneBy(array(
                'Clase' => $NombreClase
            ));
            
            $entity->setTramiteTipo($TramiteTipo);
        }
        
        $this->AsociarEstadosRequisitos($entity, null, $entity->getTramiteTipo()->getAsociacionRequisitos());
        
        return $res;
    }
    
    protected function AsociarEstadosRequisitos($entity, $EstadoRequisitoPadre, $Asociaciones) {

        // Crear (en cero) los estados de los requisitos asociados a este trámite.
        foreach($Asociaciones as $AsociacionRequisito) {
            // Primero busco para ver si ya existe
            $EstadoRequisito = null;
            if($entity->getEstadosRequisitos()) {
                foreach($entity->getEstadosRequisitos() as $EstReq) {
                    if($EstReq->getAsociacionRequisito() === $AsociacionRequisito) {
                        // Ya existe, por lo tanto no lo agrego
                        $EstadoRequisito = $EstReq;
                        break;
                    }
                }
            }

            if($EstadoRequisito == null) {
                // No existe, así que la creo
                $EstadoRequisito = new \Yacare\TramitesBundle\Entity\EstadoRequisito();
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

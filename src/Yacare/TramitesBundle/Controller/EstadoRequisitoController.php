<?php

namespace Yacare\TramitesBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("estadorequisito/")
 */
class EstadoRequisitoController extends \Yacare\BaseBundle\Controller\YacareAbmController
{
    use \Yacare\BaseBundle\Controller\ConAdjuntos {
        \Yacare\BaseBundle\Controller\ConAdjuntos::guardarActionPrePersist as ConAdjuntos_guardarActionPrePersist;
    }
    
    public function __construct() {
        parent::__construct();
        $this->ConservarVariables = array('parent_id');
        $this->Paginar = false;
    }
    
    /**
     * @Route("listar/")
     * @Template()
     */
    function listarAction() {
        $request = $this->getRequest();
        $parent_id = $request->query->get('parent_id');

        if($parent_id) {
            $em = $this->getDoctrine()->getManager();
            $parent_id = $this->getRequest()->query->get('parent_id');
            $Tramite = $em->getReference('YacareTramitesBundle:Tramite', $parent_id);

            $this->Where .= " AND r.Tramite=$parent_id";
        }
        
        $res = parent::listarAction();
        
        if($parent_id) {
            $res['parent'] = $Tramite;
        }
        
        return $res;
    }
    
    public function guardarActionPrePersist($entity, $editForm) {
        $this->ConAdjuntos_guardarActionPrePersist($entity, $editForm);
        
        if($entity->getEstado() == 100 && !$entity->getFechaAprobado()) {
            //Al cambiar el estado por "aprobado", marco la fecha en la que fue aprobado
            $entity->setFechaAprobado(new \DateTime());
        }
        
        if($entity->getEstado() > 0 && $entity->getTramite()->getEstado() == 0) {
            // Doy el trámite por iniciado
            $em = $this->getDoctrine()->getManager();

            $entity->getTramite()->setEstado(10);
            $em->persist($entity->getTramite());
        } /* else if($entity->getTramite()->getEstado() != 100 && $entity->getTramite()->RequisitosFaltantesCantidad() == 0) {
            // Doy el trámite por terminado
            $em = $this->getDoctrine()->getManager();

            $entity->getTramite()->setEstado(100);
            $em->persist($entity->getTramite());
        } */
    }

    protected function guardarActionAfterSuccess($entity) {
        // Redirecciono al trámite original en el bundle al cual corresponde el trámite

        // get_class() devuelve Yacare\TalBundle\Entity\TalEntidad
        // Tomo el segundo y cuarto valor (índices 1 y 3)
        $PartesNombreClase = explode('\\', get_class($entity->getTramite()));

        $BundleName = $PartesNombreClase[1];
        if(strlen($BundleName) > 6 && substr($BundleName, -6) == 'Bundle') {
            // Quitar la palabra 'Bundle' del nombre del bundle
            $BundleName = substr($BundleName, 0, strlen($BundleName) - 6);
        }

        $EntityName = $PartesNombreClase[3];
        if(strlen($EntityName) > 10 && substr($EntityName, -10) == 'Controller') {
            // Quitar la palabra 'Controller' del nombre del controlador
            $EntityName = substr($EntityName, 0, strlen($EntityName) - 10);
        }
        
        return $this->redirect($this->generateUrl('yacare_' . strtolower($BundleName) . '_' . strtolower($EntityName) . '_ver', $this->ArrastrarVariables(array('id' => $entity->getTramite()->getId()), false)));
    }
}

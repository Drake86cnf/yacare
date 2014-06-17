<?php

namespace Yacare\TramitesBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Controlador de tipos de trámite.
 * 
 * @see Yacare\TramitesBundle\Entity\TramiteTipo
 * @Route("tramitetipo/")
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class TramiteTipoController extends \Tapir\BaseBundle\Controller\AbmController
{
    public function guardarActionPrePersist($entity, $editForm) {
        // Crear o actualizar un requisito asociado

        $RequisitoEspejo = $entity->getRequisitoEspejo();
        if(!$RequisitoEspejo) {
            $RequisitoEspejo = new \Yacare\TramitesBundle\Entity\Requisito();
        }
        
        $RequisitoEspejo->setTramiteTipoEspejo($entity);
        $RequisitoEspejo->setTipo('tra');
        $RequisitoEspejo->setNombre((string)$entity);
        
        $entity->setRequisitoEspejo($RequisitoEspejo);
        
        parent::guardarActionPrePersist($entity, $editForm);
    }
}

<?php

namespace Yacare\TramitesBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("tramitetipo/")
 */
class TramiteTipoController extends \Yacare\BaseBundle\Controller\YacareAbmController
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

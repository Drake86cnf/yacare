<?php

namespace Yacare\TramitesBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("comprobantetipo/")
 */
class ComprobanteTipoController extends \Tapir\BaseBundle\Controller\AbmController
{
    public function guardarActionPrePersist($entity, $editForm) {
        // Crear o actualizar un instrumento asociado

        $InstrumentoEspejo = $entity->getInstrumentoEspejo();
        if (!$InstrumentoEspejo) {
            $InstrumentoEspejo = new \Yacare\TramitesBundle\Entity\Instrumento();
        }
        
        $InstrumentoEspejo->setTipo('com');
        $InstrumentoEspejo->setCodigo($entity->getCodigo());
        $InstrumentoEspejo->setNombre($entity->getNombre());
        
        $entity->setInstrumentoEspejo($InstrumentoEspejo);
        
        parent::guardarActionPrePersist($entity, $editForm);
    }
}

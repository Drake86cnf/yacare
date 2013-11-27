<?php

namespace Yacare\BromatologiaBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("libreta/")
 */
class LibretaController extends \Yacare\BaseBundle\Controller\YacareAbmController
{
    use \Yacare\BaseBundle\Controller\ConEliminar;
    
    public function guardarActionPrePersist($entity, $editForm)
    {
        // Verficiar si tiene el curso BPM al día
        // 
        // $entity
        // return array('', '');
        
        return parent::guardarActionPrePersist($entity, $editForm);
    }
}

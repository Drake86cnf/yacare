<?php

namespace Yacare\BromatologiaBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("libretas/")
 */
class LibretasController extends \Yacare\BaseBundle\Controller\YacareBaseController
{
    use \Yacare\BaseBundle\Controller\ConEliminar;
    
    public function guardarActionPrePersist($entity)
    {
        // Verficiar si tiene el curso BPM al día
        // 
        // $entity
        // return array('', '');
        
        return parent::guardarActionPrePersist($entity);
    }
}

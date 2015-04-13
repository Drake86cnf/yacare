<?php
namespace Yacare\ComprasBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * @Route("licitacion/")
 */
class LicitacionController extends \Tapir\BaseBundle\Controller\AbmController
{
    use \Yacare\BaseBundle\Controller\ConImprimir;
    use \Tapir\BaseBundle\Controller\ConEliminar;
    use \Yacare\BaseBundle\Controller\ConQr;

    /**
     * Intervengo guardar para recalcular complejidad.
     */
    public function guardarActionPrePersist($entity, $editForm)
    {
        $entity->ComputarComplejidad();
        
        return null;
    }

    /**
     * Muestra una pantalla de información sobre el cálculo de la licitación.
     *
     * @Route("ayuda/")
     * @Template()
     */
    public function ayudaAction()
    {
        return $this->ArrastrarVariables(array());
    }
}

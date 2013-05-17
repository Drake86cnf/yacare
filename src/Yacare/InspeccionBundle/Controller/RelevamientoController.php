<?php

namespace Yacare\InspeccionBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("relevamiento/")
 */
class RelevamientoController extends \Yacare\BaseBundle\Controller\YacareBaseController
{
    function __construct() {
        $this->BundleName = 'Inspeccion';
        $this->EntityName = 'Relevamiento';
        $this->UsePaginator = true;
        parent::__construct();
    }
    
    /**
     * @Route("relevamiento/preparar/{id}")
     * @Template()
     */
    public function prepararAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('Yacare' . $this->BundleName . 'Bundle:' . $this->EntityName)->find($id);
        $total_partidas = 0;
        
        foreach ($entity->getAsignaciones() as $Asignacion) {
            if($Asignacion->getCalle()) {
                // Es por calle
                $partidas = $em->getRepository('YacareCatastroBundle:Partida')->findBy(array('Calle' => $Asignacion->getCalle()));
                foreach ($partidas as $partida) {
                    $total_partidas++;
                }
            } else {
                // Es por S-M
            }
        }

        return array(
            'entity'      => $entity,
            'total_partidas'      => $total_partidas,
            'id'          => $id
        );
    }
}

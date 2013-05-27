<?php

namespace Yacare\InspeccionBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("relevamientoasignaciondetalle/")
 */
class RelevamientoAsignacionDetalleController extends \Yacare\BaseBundle\Controller\YacareBaseController
{
    function __construct() {
        $this->BundleName = 'Inspeccion';
        $this->EntityName = 'RelevamientoAsignacionDetalle';
        $this->Where = 'r.Resultado1 IS NOT NULL';
        $this->UsePaginator = true;
        parent::__construct();
    }
    
    /**
     * @Route("listarrelevamiento/{id}")
     * @Template("YacareInspeccionBundle:RelevamientoAsignacionDetalle:listar.html.twig")
     */
    public function listarrelevamientoAction($id)
    {
        $res = parent::listarAction();
        $res['id'] = $id;
        
        return $res;
    }
    
    /**
     * @Route("imagen/{id}")
     */
    public function imagenAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        /* @var $entity Document */
        $entity = $em->getRepository('Yacare' . $this->BundleName . 'Bundle:' . $this->EntityName)->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Document entity.');
        }

        $file = stream_get_contents($entity->getImagen());

        $response = new \Symfony\Component\HttpFoundation\Response($file, 200, array(
            'Content-Type' => 'image/png',
            'Content-Length' => strlen($file),
            'Content-Disposition' => 'filename="' . 'Yacare' . $this->BundleName . 'Bundle_' . $this->EntityName . '_' . $entity->getId() . '.png"',
        ));

        return $response;
    }
}

<?php

namespace Yacare\InspeccionBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("relevamientoasignacionresultado/")
 */
class RelevamientoAsignacionResultadoController extends \Yacare\BaseBundle\Controller\YacareBaseController
{
    function __construct() {
        $this->BundleName = 'Inspeccion';
        $this->EntityName = 'RelevamientoAsignacionResultado';
        parent::__construct();
    }
    
    /**
     * @Route("listarrelevamiento/{id}")
     * @Template("YacareInspeccionBundle:RelevamientoAsignacionResultado:listar.html.twig")
     */
    public function listarrelevamientoAction($id)
    {
        $request = $this->getRequest();
        
        $filtro_asignacion = $request->query->get('filtro_asignacion');
        
        if($filtro_asignacion)
            $this->Where .= " AND r.Asignacion=$filtro_asignacion";

        $res = parent::listarAction();
        
        $em = $this->getDoctrine()->getManager();
        $query_secciones = $em->createQuery("SELECT DISTINCT r.Seccion FROM YacareCatastroBundle:Partida r ORDER BY r.Seccion");
        $res['secciones'] = $query_secciones->getResult();
        
        $res['id'] = $id;
        return $res;
    }
}

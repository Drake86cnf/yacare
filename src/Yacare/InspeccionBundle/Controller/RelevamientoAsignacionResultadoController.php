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
class RelevamientoAsignacionResultadoController extends \Tapir\BaseBundle\Controller\AbmController
{
    /*
UPDATE Inspeccion_RelevamientoAsignacionResultado 
	SET Inspeccion_RelevamientoAsignacionResultado.Asignacion_id=(
		SELECT Inspeccion_RelevamientoAsignacionDetalle.Asignacion_id FROM Inspeccion_RelevamientoAsignacionDetalle
			WHERE Inspeccion_RelevamientoAsignacionDetalle.id=Inspeccion_RelevamientoAsignacionResultado.Detalle_id
	);
UPDATE Inspeccion_RelevamientoAsignacion
	SET DetallesResultadosCantidad=(
		SELECT COUNT(id) FROM Inspeccion_RelevamientoAsignacionResultado
			WHERE Inspeccion_RelevamientoAsignacionResultado.Asignacion_id=Inspeccion_RelevamientoAsignacion.id
	);
     */
    
    use \Yacare\BaseBundle\Controller\ConImagen;
    
    function __construct() {
        $this->ConservarVariables[] = 'filtro_relevamiento';
        $this->ConservarVariables[] = 'filtro_asignacion';
        
        parent::__construct();
    }
    
    /**
     * @Route("listar/")
     * @Template()
     */
    public function listarAction(Request $request) {
        $filtro_relevamiento = $request->query->get('filtro_relevamiento');
        $filtro_asignacion = $request->query->get('filtro_asignacion');
        
        if($filtro_relevamiento) {
            $this->Joins[] = " JOIN r.Asignacion a";
            
            $this->Where .= " AND a.Relevamiento=$filtro_relevamiento";
        }
        
        if($filtro_asignacion) {
            $this->Where .= " AND r.Asignacion=$filtro_asignacion";
        }
        
        return parent::listarAction($request);
    }
    
    
    /**
     * @Route("listarrelevamiento/{id}")
     * @Template("YacareInspeccionBundle:RelevamientoAsignacionResultado:listar.html.twig")
     */
    public function listarrelevamientoAction(Request $request, $id)
    {
        $filtro_asignacion = $request->query->get('filtro_asignacion');
        
        if($filtro_asignacion)
            $this->Where .= " AND r.Asignacion=$filtro_asignacion";

        $res = parent::listarAction($request);
        
        $em = $this->getDoctrine()->getManager();
        $query_secciones = $em->createQuery("SELECT DISTINCT r.Seccion FROM YacareCatastroBundle:Partida r ORDER BY r.Seccion");
        $res['secciones'] = $query_secciones->getResult();
        
        $res['id'] = $id;
        return $res;
    }
}



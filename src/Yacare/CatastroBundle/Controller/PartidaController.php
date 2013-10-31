<?php

namespace Yacare\CatastroBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("partida/")
 */
class PartidaController extends \Yacare\BaseBundle\Controller\YacareAbmController
{
    function __construct() {
        parent::__construct();
        
        $this->ConservarVariables[] = 'filtro_seccion';
        $this->ConservarVariables[] = 'filtro_macizo';
        $this->ConservarVariables[] = 'filtro_partida';
        $this->BuscarPor = 'Numero, Nombre';
        $this->OrderBy = 'Seccion, MacizoNum, ParcelaNum';
    }
    
    /**
     * @Route("buscar/")
     * @Template()
     */
    public function buscarAction()
    {
        $res = parent::buscarAction();
        
        $res['secciones'] = $this->ObtenerSecciones();
        $res['calles'] = $this->ObtenerCalles();
        
        return $res;
    }
    
    
    /**
     * @Route("buscarresultados/")
     * @Template()
     */
    public function buscarresultadosAction()
    {
        $res = parent::buscarresultadosAction();
        
        $res['secciones'] = $this->ObtenerSecciones();
        $res['calles'] = $this->ObtenerCalles();
        
        return $res;
    }
    
    // ************** Al importar:
    //UPDATE Catastro_Partida SET MacizoAlfa='' WHERE MacizoAlfa='.';
    //UPDATE Catastro_Partida SET ParcelaAlfa='' WHERE ParcelaAlfa='.';
    //UPDATE Catastro_Partida SET Nombre=CONCAT('Sección ', Seccion, ', macizo ', MacizoNum, MacizoAlfa, ', parcela ', ParcelaNum, ParcelaAlfa),
    //      Macizo=CONCAT(MacizoNum, MacizoAlfa), Parcela=CONCAT(ParcelaNum, ParcelaAlfa);
    
    /**
     * @Route("listar/")
     * @Template()
     */
    function listarAction() {
        $request = $this->getRequest();
        $filtro_seccion = $request->query->get('filtro_seccion');
        $filtro_macizo = $request->query->get('filtro_macizo');
        $filtro_partida = $request->query->get('filtro_partida');
        $filtro_calle = $request->query->get('filtro_calle');
        $filtro_calle_altura = $request->query->get('filtro_calle_altura');
        $filtro_titular = $request->query->get('filtro_titular');
        
        if($filtro_seccion == '-') {
            $this->Where .= " AND r.Seccion<'A' OR r.Seccion>'X'";
        } else if($filtro_seccion) {
            $this->Where .= " AND r.Seccion='$filtro_seccion'";
        }
        
        if($filtro_macizo) {
            $this->Where .= " AND r.Macizo='$filtro_macizo'";
        }
        
        if($filtro_partida) {
            $this->Where .= " AND r.Numero='$filtro_partida'";
        }
        
        if($filtro_calle) {
            $this->Where .= " AND r.DomicilioCalle=$filtro_calle";
            if($filtro_calle_altura) {
                $altura1 = $filtro_calle_altura - 30;
                $altura2 = $filtro_calle_altura + 30;
                $this->Where .= " AND r.DomicilioNumero BETWEEN $altura1 AND $altura2";
            }
        }
        
        if($filtro_titular) {
            $this->Joins[] = " JOIN r.Titular p";
            $this->Where .= " AND (p.NombreVisible LIKE '%$filtro_titular%'
                OR p.RazonSocial LIKE '%$filtro_titular%'
                OR p.DocumentoNumero LIKE '%$filtro_titular%'
                OR p.Cuilt LIKE '%$filtro_titular%'
                )";
        }
        
        $res = parent::listarAction();
        
        $res['secciones'] = $this->ObtenerSecciones();
        
        return $res;
    }
    
    private function ObtenerSecciones() {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery("SELECT DISTINCT r.Seccion FROM YacareCatastroBundle:Partida r ORDER BY r.Seccion");
        return $query->getResult();
    }
    
    private function ObtenerCalles() {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery("SELECT r FROM YacareCatastroBundle:Calle r ORDER BY r.Nombre");
        return $query->getResult();
    }
}

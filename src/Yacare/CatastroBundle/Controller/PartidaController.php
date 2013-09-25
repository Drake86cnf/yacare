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
        $this->BuscarPor = 'Numero';
        $this->OrderBy = 'Seccion, Macizo, Parcela';
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
        
        if($filtro_seccion == '-') {
            $this->Where .= " AND r.Seccion=''";
        } else if($filtro_seccion) {
            $this->Where .= " AND r.Seccion='$filtro_seccion'";
        }
        
        if($filtro_macizo) {
            $this->Where .= " AND r.Macizo='$filtro_macizo'";
        }
        
        if($filtro_partida) {
            $this->Where .= " AND r.Numero='$filtro_partida'";
        }

        $res = parent::listarAction();
        
        $em = $this->getDoctrine()->getManager();
        $query_secciones = $em->createQuery("SELECT DISTINCT r.Seccion FROM YacareCatastroBundle:Partida r ORDER BY r.Seccion");
        $res['secciones'] = $query_secciones->getResult();
        
        return $res;
    }
}

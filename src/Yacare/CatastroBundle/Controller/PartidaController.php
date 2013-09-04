<?php

namespace Yacare\CatastroBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("partida/")
 */
class PartidaController extends \Yacare\BaseBundle\Controller\YacareBaseController
{
    // ************** Al importar:
    //UPDATE Catastro_Partida SET MacizoAlfa='' WHERE MacizoAlfa='.';
    //UPDATE Catastro_Partida SET ParcelaAlfa='' WHERE ParcelaAlfa='.';
    //UPDATE Catastro_Partida SET Nombre=CONCAT('Sección ', Seccion, ', macizo ', MacizoNum, MacizoAlfa, ', parcela ', ParcelaNum, ParcelaAlfa),
    //      Macizo=CONCAT(MacizoNum, MacizoAlfa), Parcela=CONCAT(ParcelaNum, ParcelaAlfa);
    
    function __construct() {
        $this->BundleName = 'Catastro';
        $this->EntityName = 'Partida';
        parent::__construct();
    }
    
    /**
     * @Route("listar/")
     * @Template()
     */
    function listarAction() {
        $request = $this->getRequest();
        $filtro_seccion = $request->query->get('filtro_seccion');
        $filtro_macizo = $request->query->get('filtro_macizo');
        
        if($filtro_seccion == '-')
            $this->Where .= " AND r.Seccion=''";
        else if($filtro_seccion)
            $this->Where .= " AND r.Seccion='$filtro_seccion'";
        
        if($filtro_macizo)
            $this->Where .= " AND r.Macizo='$filtro_macizo'";

        $res = parent::listarAction();
        
        $em = $this->getDoctrine()->getManager();
        $query_secciones = $em->createQuery("SELECT DISTINCT r.Seccion FROM YacareCatastroBundle:Partida r ORDER BY r.Seccion");
        $res['secciones'] = $query_secciones->getResult();
        
        return $res;
    }
}

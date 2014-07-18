<?php

namespace Yacare\ComercioBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("local/")
 */
class LocalController extends \Tapir\BaseBundle\Controller\AbmController
{
    use \Tapir\BaseBundle\Controller\ConEliminar;
    use \Tapir\BaseBundle\Controller\ConBuscar;

    function IniciarVariables() {
        parent::IniciarVariables();
        
        $this->BuscarPor = null;
    }
    
    
    /**
     * @Route("listar/")
     * @Template()
     */
    public function listarAction(Request $request) {
        $filtro_buscar = $request->query->get('filtro_buscar');
        
        if($filtro_buscar) {
            $this->Joins[] = " JOIN r.Partida p";
            $this->Joins[] = " JOIN p.Titular t";
            
            // Busco por varias palabras
            // cambio , por espacio, quito espacios dobles y divido la cadena en los espacios
            $palabras = explode(' ', str_replace('  ', ' ', str_replace(',', ' ', $filtro_buscar)), 5);
            foreach ($palabras as $palabra) {
                $this->Where .= " AND (p.Nombre LIKE '%$palabra%'
                    OR t.NombreVisible LIKE '%$palabra%'
                    OR t.RazonSocial LIKE '%$palabra%'
                    OR t.DocumentoNumero LIKE '%$palabra%'
                    OR t.Cuilt LIKE '%$palabra%')";
            }
        }
        
        $res = parent::listarAction($request);
        
        return $res;
    }
}

<?php

namespace Yacare\ComercioBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("local/")
 */
class LocalController extends \Yacare\BaseBundle\Controller\YacareAbmController
{
    use \Yacare\BaseBundle\Controller\ConEliminar;
    use \Yacare\BaseBundle\Controller\ConBuscar;

    public function __construct() {
        $this->BundleName = 'Comercio';
        $this->EntityName = 'Local';
        parent::__construct();
        $this->BuscarPor = null;
    }
    
    
    /**
     * @Route("listar/")
     * @Template()
     */
    function listarAction() {
        $request = $this->getRequest();
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
        
        $res = parent::listarAction();
        
        return $res;
    }
}

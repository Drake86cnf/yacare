<?php
namespace Yacare\ComercioBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

/**
 * Controlador de comercio.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 * @author Ezequiel Riquelme <rezequiel.tdf@gmail.com>
 * 
 * @Route("comercio/")
 */
class ComercioController extends \Tapir\AbmBundle\Controller\AbmController
{
    use \Tapir\AbmBundle\Controller\ConBuscar;
    
    function IniciarVariables()
    {
        parent::IniciarVariables();
    
        $this->BuscarPor = null;
    }

    /**
     * @Route("listar/")
     * @Template()
     */
    public function listarAction(Request $request)
    {
        $filtro_buscar = $this->ObtenerVariable($request, 'filtro_buscar');
    
        if ($filtro_buscar) {
            $this->Joins[] = " LEFT JOIN r.Titular t";
            $this->Joins[] = " LEFT JOIN r.Local l";
    
            // Busco por varias palabras
            // cambio , por espacio, quito espacios dobles y divido la cadena en los espacios
            $palabras = explode(' ', str_replace('  ', ' ', str_replace(',', ' ', $filtro_buscar)), 5);
            foreach ($palabras as $palabra) {
                $this->Where .= " AND (r.Nombre LIKE '%$palabra%'
                OR r.ExpedienteNumero LIKE '%$palabra%'
                OR l.Nombre LIKE '%$palabra%'
                OR t.NombreVisible LIKE '%$palabra%'
                OR t.RazonSocial LIKE '%$palabra%'
                OR t.DocumentoNumero LIKE '%$palabra%'
                OR t.Cuilt LIKE '%$palabra%')";
            }
        }
        $res = parent::listarAction($request);
    
        return $res;
    }

    /**
     * @Route("altamanual/")
     * @Template()
     */
    function altamanualAction(Request $request)
    {
        return $this->ArrastrarVariables($request);
    }
}

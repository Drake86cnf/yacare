<?php
namespace Yacare\ComercioBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Controlador de actas de comercio.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 * 
 * @Route("actacomercio/")
 */
class ActaComercioController extends \Tapir\AbmBundle\Controller\AbmController
{
    use \Tapir\AbmBundle\Controller\ConVer;
    
    function IniciarVariables()
    {
        parent::IniciarVariables();
        
        $this->BuscarPor = null;
        $this->OrderBy = 'Fecha DESC';
    }

    /**
     * @Route("listar/")
     * @Template()
     */
    public function listarAction(Request $request)
    {
        $filtro_buscar = $this->ObtenerVariable($request, 'filtro_buscar');
    
        if ($filtro_buscar) {
            $this->Joins[] = " LEFT JOIN r.Comercio c";
            $this->Joins[] = " LEFT JOIN c.Titular t";
            $this->Joins[] = " LEFT JOIN c.Local l";
    
            // Busco por varias palabras
            // cambio , por espacio, quito espacios dobles y divido la cadena en los espacios
            $palabras = explode(' ', str_replace('  ', ' ', str_replace(',', ' ', $filtro_buscar)), 5);
            foreach ($palabras as $palabra) {
                $this->Where .= " AND (c.Nombre LIKE '%$palabra%'
                OR r.Numero LIKE '%$palabra%'
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
    
    protected function CrearNuevaEntidad(Request $request)
    {
        $em = $this->getEm();
        $entidad = parent::CrearNuevaEntidad($request);
        
        $ComercioId = $this->ObtenerVariable($request, 'comercio');
        if($ComercioId > 0) {
            $entidad->setComercio($em->getReference('YacareComercioBundle:Comercio', $ComercioId));
        }
        
        return $entidad;
    }
} 

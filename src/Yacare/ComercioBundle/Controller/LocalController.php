<?php
namespace Yacare\ComercioBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Controlador de local.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 *
 * @Route("local/")
 */
class LocalController extends \Tapir\AbmBundle\Controller\AbmController
{
    use \Tapir\AbmBundle\Controller\ConVer;
    use \Tapir\AbmBundle\Controller\ConEliminar;
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
            $this->Joins[] = " LEFT JOIN r.Partida p";
            $this->Joins[] = " LEFT JOIN p.Titular t";
            $this->Joins[] = " LEFT JOIN r.DomicilioCalle dc";

            // Busco por varias palabras
            // cambio , por espacio, quito espacios dobles y divido la cadena en los espacios
            $palabras = explode(' ', str_replace('  ', ' ', str_replace(',', ' ', $filtro_buscar)), 5);
            foreach ($palabras as $palabra) {
                $this->Where .= " AND (r.Nombre LIKE '%$palabra%'
                    OR p.Nombre LIKE '%$palabra%'
                    OR dc.Nombre LIKE '%$palabra%'
                    OR r.DomicilioNumero LIKE '%$palabra%'
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

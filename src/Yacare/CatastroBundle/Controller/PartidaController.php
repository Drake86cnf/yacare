<?php
namespace Yacare\CatastroBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Controlador para partida inmobiliaria.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 *
 * @Route("partida/")
 */
class PartidaController extends \Tapir\AbmBundle\Controller\AbmController
{
    use \Tapir\AbmBundle\Controller\ConVer;
    use \Tapir\AbmBundle\Controller\ConBuscar {
    	\Tapir\AbmBundle\Controller\ConBuscar::buscarAction as parent_buscarAction;
    }

    function IniciarVariables()
    {
        parent::IniciarVariables();

        $this->ConservarVariables[] = 'filtro_seccion';
        $this->ConservarVariables[] = 'filtro_macizo';
        $this->ConservarVariables[] = 'filtro_buscar';
        $this->BuscarPor = 'Numero, Nombre';
        $this->OrderBy = 'Seccion, MacizoNum, ParcelaNum';
    }

    /**
     * @Route("buscar/")
     * @Template()
     */
    public function buscarAction(Request $request)
    {
        $res = $this->parent_buscarAction($request);
        $res['calles'] = $this->ObtenerCalles();
        return $res;
    }

    /**
     * @Route("listar/")
     * @Template()
     */
    public function listarAction(Request $request)
    {
        $filtro_seccion = $this->ObtenerVariable($request, 'filtro_seccion');
        $filtro_macizo = $this->ObtenerVariable($request, 'filtro_macizo');
        $filtro_partida = $this->ObtenerVariable($request, 'filtro_partida');
        $filtro_calle = $this->ObtenerVariable($request, 'filtro_calle');
        $filtro_calle_altura = $this->ObtenerVariable($request, 'filtro_calle_altura');
        $filtro_buscar = $this->ObtenerVariable($request, 'filtro_buscar');

        if ($filtro_buscar) {
            $this->Joins[] = " JOIN r.Titular p";
            $this->BuscarPor .= ', p.NombreVisible, p.RazonSocial, p.DocumentoNumero, p.Cuilt';
        } else {
            if ($filtro_seccion == '-') {
                $this->Where .= " AND r.Seccion<'A' OR r.Seccion>'X'";
                $this->BuscarPor = null;
            } elseif ($filtro_seccion) {
                $this->Where .= " AND r.Seccion='$filtro_seccion'";
                $this->BuscarPor = null;
            }
    
            if ($filtro_macizo) {
                $this->Where .= " AND CONCAT(r.MacizoNum, r.MacizoAlfa) LIKE '$filtro_macizo'";
                $this->BuscarPor = null;
            }
    
            if ($filtro_partida) {
                $this->Where .= " AND r.Numero='$filtro_partida'";
                $this->BuscarPor = null;
            }
    
            if ($filtro_calle) {
                $this->Where .= " AND r.DomicilioCalle=$filtro_calle";
                if ($filtro_calle_altura) {
                    $altura1 = $filtro_calle_altura - 30;
                    $altura2 = $filtro_calle_altura + 30;
                    $this->Where .= " AND r.DomicilioNumero BETWEEN $altura1 AND $altura2";
                }
                $this->BuscarPor = null;
            }
        }
        

        $res = parent::listarAction($request);

        $res['secciones'] = $this->ObtenerSecciones();

        return $res;
    }

    /**
     * Devuelve todas las secciones de las partidas.
     *
     * @return \Yacare\CatastroBundle\Entity\Partida
     */
    private function ObtenerSecciones()
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery("SELECT DISTINCT r.Seccion FROM YacareCatastroBundle:Partida r ORDER BY r.Seccion");
        return $query->getResult();
    }

    /**
     * Devuelve todas las calles.
     *
     * @return \Yacare\CatastroBundle\Entity\Calle
     */
    private function ObtenerCalles()
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery("SELECT r FROM YacareCatastroBundle:Calle r ORDER BY r.Nombre");
        return $query->getResult();
    }
}

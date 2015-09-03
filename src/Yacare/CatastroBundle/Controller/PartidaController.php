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
class PartidaController extends \Tapir\BaseBundle\Controller\AbmController
{
    use \Tapir\BaseBundle\Controller\ConBuscar {
    	\Tapir\BaseBundle\Controller\ConBuscar::buscarAction as parent_buscarAction;
    }

    function IniciarVariables()
    {
        parent::IniciarVariables();
        
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
    public function buscarAction(Request $request)
    {
        $res = $this->parent_buscarAction($request);
        $res['calles'] = $this->ObtenerCalles();
        return $res;
    }
    
    // ************** Al importar:
    // UPDATE Catastro_Partida SET MacizoAlfa='' WHERE MacizoAlfa='.';
    // UPDATE Catastro_Partida SET ParcelaAlfa='' WHERE ParcelaAlfa='.';
    // UPDATE Catastro_Partida SET Nombre=CONCAT('Sección ', Seccion, ', macizo ', MacizoNum, MacizoAlfa, ', parcela ',
    // ParcelaNum, ParcelaAlfa),
    // Macizo=CONCAT(MacizoNum, MacizoAlfa), Parcela=CONCAT(ParcelaNum, ParcelaAlfa);
    
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
        
        if ($filtro_seccion == '-') {
            $this->Where .= " AND r.Seccion<'A' OR r.Seccion>'X'";
            $this->BuscarPor = null;
        } elseif ($filtro_seccion) {
            $this->Where .= " AND r.Seccion='$filtro_seccion'";
            $this->BuscarPor = null;
        }
        
        if ($filtro_macizo) {
            $this->Where .= " AND r.Macizo LIKE '$filtro_macizo'";
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
        
        if ($filtro_buscar) {
            $this->Joins[] = " JOIN r.Titular p";
            
            // Busco por varias palabras
            // cambio , por espacio, quito espacios dobles y divido la cadena en los espacios
            $palabras = explode(' ', str_replace('  ', ' ', str_replace(',', ' ', $filtro_buscar)), 5);
            foreach ($palabras as $palabra) {
                $this->Where .= " AND (p.NombreVisible LIKE '%$palabra%'
                    OR p.RazonSocial LIKE '%$paparalabra%'
                    OR p.DocumentoNumero LIKE '%$palabra%'
                    OR p.Cuilt LIKE '%$palabra%')";
            }
            $this->BuscarPor = null;
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

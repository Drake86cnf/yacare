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
    use \Tapir\AyudaBundle\Controller\ConAyuda;
    use \Tapir\AbmBundle\Controller\ConVer;
    use \Tapir\AbmBundle\Controller\ConBuscar;
    use \Yacare\BaseBundle\Controller\ConRequiereAtencion;
    //use \Yacare\InspeccionBundle\Controller\ConTurno;
    
    function IniciarVariables()
    {
        parent::IniciarVariables();
    
        $this->OrderBy = 'RequiereAtencion DESC, Nombre';
        $this->BuscarPor = null;
    }

    /**
     * @Route("listar/")
     * @Template()
     */
    public function listarAction(Request $request)
    {
        $filtro_buscar = $this->ObtenerVariable($request, 'filtro_buscar');
        $filtro_estado = $this->ObtenerVariable($request, 'filtro_estado');
    
        if ($filtro_estado) {
            if($filtro_estado == -1) {
                // El -1 tiene el valor especial de Estado=0
                $this->Where .= " AND r.Estado=0";
            } else {
                $this->Where .= " AND r.Estado=$filtro_estado";
            }
        }
        if ($filtro_buscar) {
            $this->Joins[] = " LEFT JOIN r.Titular t";
            $this->Joins[] = " LEFT JOIN r.Local l";
    
            $this->BuscarPor = 'Nombre, ExpedienteNumero, l.Nombre, t.NombreVisible, t.RazonSocial, t.DocumentoNumero, t.Cuilt';
        }
        
        $RestuladoListar = parent::listarAction($request);
        $res = $RestuladoListar['res'];
        
        $res->Estados = \Yacare\ComercioBundle\Entity\Comercio::NombresEstados();
    
        return $RestuladoListar;
    }

    /**
     * @Route("altamanual/")
     * @Template()
     */
    function altamanualAction(Request $request)
    {
        $res = $this->ConstruirResultado(new \Tapir\BaseBundle\Helper\Resultados\ResultadoActionBaseController($this),
            $request);
        
        return array('res' => $res);
    }
}

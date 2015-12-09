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
    
            $this->BuscarPor = 'Nombre, ExpedienteNumero, l.Nombre, t.NombreVisible, t.RazonSocial, t.DocumentoNumero, t.Cuilt';
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
        $res = $this->ConstruirResultado(new \Tapir\BaseBundle\Helper\Resultados\ResultadoActionBaseController($this),
            $request);
        
        return array('res' => $res);
    }
}

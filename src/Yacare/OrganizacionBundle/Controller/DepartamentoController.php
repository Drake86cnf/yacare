<?php
namespace Yacare\OrganizacionBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Controlador de departamentos municipales.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 * 
 * @Route("departamento/")
 */
class DepartamentoController extends \Tapir\AbmBundle\Controller\AbmController
{
    use \Tapir\AbmBundle\Controller\ConVer;
    use \Tapir\AbmBundle\Controller\ConEliminar;
    use \Tapir\AbmBundle\Controller\ConBuscar {
        \Tapir\AbmBundle\Controller\ConBuscar::buscarAction as buscarAction2;
    }

    function IniciarVariables()
    {
        parent::IniciarVariables();
        
        $this->Paginar = false;
        $this->OrderBy = "MaterializedPath";
        $this->BuscarPor = "Nombre,MaterializedPath";
    }
    
    /**
     * @Route("buscar/")
     * @Template()
     */
    public function buscarAction(Request $request)
    {
        $filtro_parent = $this->ObtenerVariable($request, 'filtro_parent');
        $filtro_parent = $this->ObtenerVariable($request, 'filtro_parent');
        if ($filtro_parent) {
            $this->Where .= " AND r.ParentNode_id=" + $filtro_parent;
        } else {
            
        }
        
        $ResultadoBuscar = $this->buscarAction2($request);
        $res = $ResultadoBuscar['res'];
    }
    
    /**
     * @Route("listar/")
     * @Template()
     */
    public function listarAction(Request $request)
    {
        $filtro_rango = $this->ObtenerVariable($request, 'filtro_rango');

        
        
        if ($filtro_rango) {
            if($filtro_rango == -1) {
                // El -1 tiene el valor especial de Rango=0
                $this->Where .= " AND r.Rango=0";
            } else {
                $this->Where .= " AND r.Rango<=$filtro_rango";
            }
        }

        $RestuladoListar = parent::listarAction($request);
        $res = $RestuladoListar['res'];

        $res->Rangos = \Yacare\OrganizacionBundle\Entity\Departamento::NombresRangos();

        return $RestuladoListar;
    }
    

    /**
     * @Route("recalcular/")
     * @Template("YacareOrganizacionBundle:Departamento:listar.html.twig")
     */
    public function recalcularAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        
        $em->getConnection()->beginTransaction();
        $items = $em->getRepository('YacareOrganizacionBundle:Departamento')->findAll();
        foreach ($items as $item) {
            $Parent = $item->getParentNode();
            $item->setParentNode($Parent);
            $em->persist($item);
        }
        $em->flush();
        $em->getConnection()->commit();

        return $this->listarAction($request);
    }
}

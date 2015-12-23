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

    function IniciarVariables()
    {
        parent::IniciarVariables();
        
        $this->Paginar = false;
        $this->OrderBy = "MaterializedPath";
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
                $this->Where .= " AND r.Rango=$filtro_rango";
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
            $item->setParentNode($item->getParentNode());
            $em->persist($item);
            
        }
        $em->flush();
        $em->getConnection()->commit();
        
        return $this->listarAction($request);
    }
}

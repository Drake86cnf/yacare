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
class DepartamentoController extends \Tapir\BaseBundle\Controller\AbmController
{
    use \Tapir\BaseBundle\Controller\ConEliminar;

    function IniciarVariables()
    {
        parent::IniciarVariables();
        
        $this->Paginar = false;
        $this->OrderBy = "MaterializedPath";
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
            $em->flush();
        }
        
        $em->getConnection()->commit();
        
        return parent::listarAction($request);
    }
}

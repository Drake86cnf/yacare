<?php

namespace Yacare\ComercioBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("actividad/")
 */
class ActividadController extends \Yacare\BaseBundle\Controller\YacareAbmController
{
    public function __construct() {
        $this->BundleName = 'Comercio';
        $this->EntityName = 'Actividad';
        $this->BuscarPor = 'Nombre,Clamae2014,Incluye';
        $this->OrderBy = 'id';
        $this->Paginar = false;
        parent::__construct();
    }
    
    /**
     * @Route("buscarresultados/")
     * @Template()
     */
    public function buscarresultadosAction(Request $request)
    {
        $this->Where = 'r.Final=1';
        return parent::buscarresultadosAction($request);
    }

    /**
     * @Route("recalcular/")
     * @Template("YacareComercioBundle:Actividad:listar.html.twig")
     */
    public function recalcularAction(Request $request) {
        set_time_limit(600);
        ini_set('memory_limit', '2048M');
        
        $em = $this->getDoctrine()->getManager();
        $em->getConnection()->beginTransaction();
        $items = $em->getRepository('YacareComercioBundle:Actividad')->findAll();
        foreach($items as $item) {
            $item->setParentNode($item->getParentNode());
            $em->persist($item);
            $em->flush();
        }
        
        $em->getConnection()->commit();
        
        return parent::listarAction($request);
    }
}

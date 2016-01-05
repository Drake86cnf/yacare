<?php
namespace Yacare\ObrasParticularesBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Controlador de movimientos de previas.
 * 
 * @author Ezequiel Riquelme <rezquiel.tdf@gmail.com>
 * 
 * @Route("tramiteplano/")
 */
class TramitePlanoController extends \Yacare\TramitesBundle\Controller\TramiteController
{    
    /**
     * @Route("adjuntos/listar/")
     * @Security("has_role('ROLE_IDDQD') or has_role('ROLE_OBRAS_PARTICULARES_ADMINISTRADOR') or has_role('ROLE_OBRAS_PARTICULARES_INSPECTOR')")
     * @Template("YacareObrasParticularesBundle:ActaObra:adjuntos_listar.html.twig")
     */
    public function adjuntoslistarAction(Request $request)
    {    
        return parent::adjuntoslistarAction($request);
    }
}

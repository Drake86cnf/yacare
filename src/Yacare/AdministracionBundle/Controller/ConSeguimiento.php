<?php
namespace Yacare\AdministracionBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Trait que agrega acciones de seguimiento.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 * 
 */
trait ConSeguimiento
{
    /**
     * @Route("seguimiento/listar")
     * @Template("YacareAdministracionBundle:Seguimiento:listar.html.twig")
     */
    public function seguimientolistarAction(Request $request)
    {
        $EntidadClase = $this->CompleteEntityName;
        $EntidadId = $this->ObtenerVariable($request, 'id');
        
        $em = $this->getDoctrine()->getManager();
        
        $NuevoSeguimiento = new \Yacare\AdministracionBundle\Entity\Seguimiento();
        $NuevoSeguimiento->setEntidadClase($EntidadClase);
        $NuevoSeguimiento->setEntidadId($EntidadId);
        
        $res = $this->ConstruirResultado(new \Tapir\AbmBundle\Helper\Resultados\ResultadoListarAction($this), $request);
        
        $FormularioComentario = $this->createForm('Yacare\AdministracionBundle\Form\SeguimientoComentarioType', $NuevoSeguimiento);
        $FormularioEnviar = $this->createForm('Yacare\AdministracionBundle\Form\SeguimientoEnviarType', $NuevoSeguimiento);
        
        $res->FormularioComentario = $FormularioComentario->createView();
        $res->FormularioEnviar = $FormularioEnviar->createView();
        $res->Entidad = $em->getRepository($EntidadClase)->find($EntidadId);
        $res->Entidades = $em->getRepository('\Yacare\AdministracionBundle\Entity\Seguimiento')->findBy([ 'EntidadClase' => $EntidadClase, 'EntidadId' => $EntidadId ]);
        
        return [ 'res' => $res ];
    }
    
    /**
     * @Route("seguimiento/comentario")
     * @Template("YacareAdministracionBundle:Seguimiento:comentario.html.twig")
     */
    public function seguimientocomentarioAction(Request $request)
    {
        $EntidadClase = $this->CompleteEntityName;
        $EntidadId = $this->ObtenerVariable($request, 'id');
    
        $em = $this->getDoctrine()->getManager();
        
        $res = $this->ConstruirResultado(new \Tapir\AbmBundle\Helper\Resultados\ResultadoListarAction($this), $request);
        $res->Entidad = $em->getRepository($EntidadClase)->find($EntidadId);
            
        $NuevoSeguimiento = new \Yacare\AdministracionBundle\Entity\Seguimiento();
        $NuevoSeguimiento->setEntidadClase($EntidadClase);
        $NuevoSeguimiento->setEntidadId($EntidadId);
    
        $FormularioComentario = $this->createForm('Yacare\AdministracionBundle\Form\SeguimientoComentarioType', $NuevoSeguimiento);
        $FormularioComentario->handleRequest($request);
        if ($FormularioComentario->isValid()) {
            $UsuarioConectado = $this->get('security.token_storage')->getToken()->getUser();
            $NuevoSeguimiento->setPersonaEnvia($UsuarioConectado);
            $em->persist($NuevoSeguimiento);
            $em->flush();
        }
        
        return $this->redirectToRoute($this->obtenerRutaBase('seguimientolistar'), $this->ArrastrarVariables($request, [ 'id' => $EntidadId ], false));
    }

    /**
     * @Route("seguimiento/enviar")
     * @Template("YacareAdministracionBundle:Seguimiento:enviar.html.twig")
     */
    public function seguimientoenviarAction(Request $request)
    {
        $EntidadClase = $this->CompleteEntityName;
        $EntidadId = $this->ObtenerVariable($request, 'id');
        
        $em = $this->getDoctrine()->getManager();
        
        $res = $this->ConstruirResultado(new \Tapir\AbmBundle\Helper\Resultados\ResultadoListarAction($this), $request);
        $res->Entidad = $em->getRepository($EntidadClase)->find($EntidadId);
            
        $NuevoSeguimiento = new \Yacare\AdministracionBundle\Entity\Seguimiento();
        $NuevoSeguimiento->setEntidadClase($EntidadClase);
        $NuevoSeguimiento->setEntidadId($EntidadId);
    
        $FormularioEnviar = $this->createForm('Yacare\AdministracionBundle\Form\SeguimientoEnviarType', $NuevoSeguimiento);
        $FormularioEnviar->handleRequest($request);
        if ($FormularioEnviar->isValid()) {
            $UsuarioConectado = $this->get('security.token_storage')->getToken()->getUser();
            $NuevoSeguimiento->setPersonaEnvia($UsuarioConectado);
            $em->persist($NuevoSeguimiento);
            $em->flush();
        }
        
        return $this->redirectToRoute($this->obtenerRutaBase('seguimientolistar'), $this->ArrastrarVariables($request, [ 'id' => $EntidadId ], false));
    }
}

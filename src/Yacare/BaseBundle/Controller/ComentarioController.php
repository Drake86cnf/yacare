<?php
namespace Yacare\BaseBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Controlador de comentarios.
 *
 * @Route("comentario/")
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class ComentarioController extends \Tapir\BaseBundle\Controller\BaseController
{

    /**
     * @Route("listar")
     * @Template()
     */
    public function listarAction(Request $request)
    {
        $tipo = $request->query->get('tipo');
        $id = $request->query->get('id');
        
        $em = $this->getDoctrine()->getManager();
        
        $NuevoComentario = new \Yacare\BaseBundle\Entity\Comentario();
        $NuevoComentario->setEntidadTipo($tipo);
        $NuevoComentario->setEntidadId($id);
        
        $editForm = $this->createForm(new \Yacare\BaseBundle\Form\ComentarioType(), $NuevoComentario);
        
        $entity = $em->getRepository($tipo)->find($id);
        
        $entities = $em->getRepository('YacareBaseBundle:Comentario')->findBy(array(
            'EntidadTipo' => $tipo,
            'EntidadId' => $id
        ));
        
        return $this->ArrastrarVariables(array(
            'form_comentario' => $editForm->createView(),
            'entity' => $entity,
            'entities' => $entities
        ));
    }

    /**
     * @Route("publicar")
     * @Method("POST")
     * @Template()
     */
    public function publicarAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        
        $NuevoComentario = new \Yacare\BaseBundle\Entity\Comentario();
        
        $editForm = $this->createForm(new \Yacare\BaseBundle\Form\ComentarioType(), $NuevoComentario);
        $editForm->handleRequest($request);
        if ($editForm->isValid()) {
            $NuevoComentario->setPersona($this->get('security.context')
                ->getToken()
                ->getUser());
            
            $em->persist($NuevoComentario);
            $em->flush();
            
            return $this->ArrastrarVariables(array(
                'entity' => $NuevoComentario
            ));
        } else {
            return $this->ArrastrarVariables(array());
        }
    }
}

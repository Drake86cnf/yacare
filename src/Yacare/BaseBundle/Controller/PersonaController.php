<?php

namespace Yacare\BaseBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Yacare\BaseBundle\Entity\Persona;
use Yacare\BaseBundle\Form\PersonaType;

/**
 * @Route("persona/")
 */
class PersonaController extends Controller
{
    /**
     * @Route("listar/")
     * @Template()
     */
    public function listarAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('YacareBaseBundle:Persona')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * @Route("editar/{id}")
     * @Route("crear/", name="yacare_base_persona_crear")
     * @Template()
     */
    public function editarAction($id = null)
    {
        $em = $this->getDoctrine()->getManager();

        if($id)
            $entity = $em->getRepository('YacareBaseBundle:Persona')->find($id);
        else
            $entity = new Persona();

        if (!$entity) {
            throw $this->createNotFoundException('No se puede encontrar la persona.');
        }

        $editForm = $this->createForm(new PersonaType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'create'      => $id ? false : true,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * @Route("guardar/{id}")
     * @Route("guardar")
     * @Method("POST")
     * @Template("YacareBaseBundle:Persona:edit.html.twig")
     */
    public function guardarAction(Request $request, $id=null)
    {
        $em = $this->getDoctrine()->getManager();

        if($id)
            $entity = $em->getRepository('YacareBaseBundle:Persona')->find($id);
        else
            $entity = new Persona();

        if (!$entity) {
            throw $this->createNotFoundException('No se puede encontrar la persona.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new PersonaType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('yacare_base_persona_listar'));
        }

        return array(
            'entity'      => $entity,
            'create'      => $id ? false : true,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * @Route("eliminar/{id}")
     * @Method("POST")
     */
    public function eliminarAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('YacareBaseBundle:Persona')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('No se puede encontrar la persona.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('yacare_base_persona_listar'));
    }

    
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}

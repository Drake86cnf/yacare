<?php

namespace Yacare\BaseBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class YacareBaseController extends Controller
{
    function __construct() {
        if(strlen($this->BundleName) > 6 && substr($this->BundleName, -6) == 'Bundle')
                // Quitar la palabra 'Bundle' del nombre del bundle
                $this->BundleName = substr($this->BundleName, 0, strlen($this->BundleName) - 6);
        
        if(!isset($this->UsePaginator))
            $this->UsePaginator = false;
    }
   
    /**
     * @Route("listar/")
     * @Template()
     */
    public function listarAction()
    {
        if($this->UsePaginator) {
            $em = $this->getDoctrine()->getManager();
            $dql   = 'SELECT a FROM Yacare' . $this->BundleName . 'Bundle:' . $this->EntityName . ' a';
            $query = $em->createQuery($dql);

            $paginator  = $this->get('knp_paginator');
            $entities = $paginator->paginate(
                $query,
                $this->get('request')->query->get('page', 1)/*page number*/,
                10/*limit per page*/
            );

            // parameters to template
            return $this->render('Yacare' . $this->BundleName . 'Bundle:' . $this->EntityName . ':listar.html.twig', array('entities' => $entities));
        } else {
            $em = $this->getDoctrine()->getManager();

            $entities = $em->getRepository('Yacare' . $this->BundleName . 'Bundle:' . $this->EntityName)->findAll();

            return array(
                'entities' => $entities,
            );
        }
    }


    /**
     * @Route("editar/{id}")
     * @Route("crear/")
     * @Template()
     */
    public function editarAction($id = null)
    {
        $em = $this->getDoctrine()->getManager();

        if($id) {
            $entity = $em->getRepository('Yacare' . $this->BundleName . 'Bundle:' . $this->EntityName)->find($id);
        } else {
            $entityName = 'Yacare\\' . $this->BundleName . 'Bundle\\Entity\\' . $this->EntityName;
            $entity = new $entityName();
        }

        if (!$entity) {
            throw $this->createNotFoundException('No se puede encontrar la entidad.');
        }

        $typeName = 'Yacare\\' . $this->BundleName . 'Bundle\\Form\\' . $this->EntityName . 'Type';
        $editForm = $this->createForm(new $typeName(), $entity);
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
     */
    public function guardarAction(Request $request, $id=null)
    {
       
        $em = $this->getDoctrine()->getManager();

        if($id) {
            $entity = $em->getRepository('Yacare' . $this->BundleName . 'Bundle:' . $this->EntityName)->find($id);
        } else {
            $entityName = 'Yacare\\' . $this->BundleName . 'Bundle\\Entity\\' . $this->EntityName;
            $entity = new $entityName();
        }

        if (!$entity) {
            throw $this->createNotFoundException('No se puede encontrar la entidad.');
        }

        $typeName = 'Yacare\\' . $this->BundleName . 'Bundle\\Form\\' . $this->EntityName . 'Type';
        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new $typeName(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl(strtolower('yacare_' . $this->BundleName . '_' . $this->EntityName . '_listar')));
        }

        // @Template("YacareBaseBundle:Dependencia:edit.html.twig")
        //$this->setTemplate('Yacare' . $this->BundleName . 'Bundle:' . $this->EntityName . ':edit.html.twig');
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
            $entity = $em->getRepository('Yacare' . $this->BundleName . 'Bundle:' . $this->EntityName)->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('No se puede encontrar la entidad.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl(strtolower('yacare_' . $this->BundleName . '_' . $this->EntityName . '_listar')));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}

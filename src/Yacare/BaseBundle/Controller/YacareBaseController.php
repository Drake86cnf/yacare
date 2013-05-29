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
        
        $this->UsePaginator = true;
        
        if(!isset($this->OrderBy))
            $this->OrderBy = null;
        
        if(!isset($this->Where))
            $this->Where = null;
    }
   
    /**
     * @Route("listar/")
     * @Template()
     */
    public function listarAction()
    {
        $em = $this->getDoctrine()->getManager();
       
        $dql = "SELECT r FROM Yacare" . $this->BundleName . "Bundle:" . $this->EntityName . " r";
        
        $where = "";
        if(in_array('Yacare\BaseBundle\Entity\Eliminable', class_uses('Yacare\\' . $this->BundleName . 'Bundle\Entity\\' . $this->EntityName))) {
            $where = "r.Eliminado=0";
        } else {
            $where = "1=1";
        }
        
        $dql .= " WHERE $where";
        if($this->Where) {
            $this->Where = trim($this->Where);
            if(substr($this->Where, 0, 4) != "AND ")
                    $this->Where = "AND " . $this->Where;
            $dql .= ' ' . $this->Where;
        }

        if($this->OrderBy)
            $dql .= " ORDER BY " . $this->OrderBy;

        $query = $em->createQuery($dql);
        
        if($this->UsePaginator) {
            $paginator  = $this->get('knp_paginator');
            $entities = $paginator->paginate(
                $query,
                $this->get('request')->query->get('page', 1) /* page number */,
                10 /* limit per page */
            );
        } else {
            $entities = $query->getResult();
        }
        
        return array(
            'entities' => $entities,
        );
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
            'create'      => $id ? false : true
        );
    }

    /**
     * @Route("eliminar/{id}")
     * @Template("YacareBaseBundle:Default:eliminar.html.twig")
     */
    public function eliminarAction($id)
    {
        $deleteForm = $this->createDeleteForm($id);

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('Yacare' . $this->BundleName . 'Bundle:' . $this->EntityName)->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se puede encontrar la entidad.');
        }

        return array(
            'entity'      => $entity,
            'bundlename'  => strtolower('yacare_' . $this->BundleName),
            'entityname'  => strtolower($this->EntityName),
            'create'      => $id ? false : true,
            'delete_form' => $deleteForm->createView(),
        );
    }
    
    
    /**
     * @Route("eliminar2/{id}")
     * @Method("POST")
     * @Template("YacareBaseBundle:Default:eliminar2.html.twig")
     */
    public function eliminar2Action(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('Yacare' . $this->BundleName . 'Bundle:' . $this->EntityName)->find($id);

            if(in_array('Yacare\BaseBundle\Entity\Eliminable', class_uses($entity))) {
                // Es soft-deletable, lo marco como borrado
                $entity->Eliminar();
                $em->persist($entity);
                $em->flush();
            } else {
                // Lo elimino de verdad
                //$em->remove($entity);
            }
        }
        
        /* return array(
            'entity'      => $entity,
            'bundlename'  => strtolower('yacare_' . $this->BundleName),
            'entityname'  => strtolower($this->EntityName),
        ); */
        return $this->redirect($this->generateUrl(strtolower('yacare_' . $this->BundleName . '_' . $this->EntityName . '_listar')));
    }
    

    protected function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
    
    /**
     * @Route("imagen/{id}")
     */
    public function imagenAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        /* @var $entity Document */
        $entity = $em->getRepository('Yacare' . $this->BundleName . 'Bundle:' . $this->EntityName)->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Document entity.');
        }

        $imagen_contenido = stream_get_contents($entity->getImagen());

        $response = new \Symfony\Component\HttpFoundation\Response($imagen_contenido, 200, array(
            'Content-Type' => 'image/png',
            'Content-Length' => strlen($imagen_contenido),
            'Content-Disposition' => 'filename="' . 'Yacare' . $this->BundleName . 'Bundle_' . $this->EntityName . '_' . $entity->getId() . '.png"',
        ));

        return $response;
    }
}

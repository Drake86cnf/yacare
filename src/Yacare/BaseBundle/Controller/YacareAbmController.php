<?php

namespace Yacare\BaseBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class YacareAbmController extends YacareBaseController
{
    function __construct() {
        parent::__construct();

        if(!isset($this->Paginar))
            $this->Paginar = true;
        
        if(!isset($this->OrderBy))
            $this->OrderBy = null;
        
        if(!isset($this->Where))
            $this->Where = null;
        
        if(!isset($this->BuscarPor))
            $this->BuscarPor = 'Nombre';
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
        
        if(in_array('Yacare\BaseBundle\Entity\Suprimible', class_uses('Yacare\\' . $this->BundleName . 'Bundle\Entity\\' . $this->EntityName))) {
            $where = "r.Suprimido=0";
        } else {
            $where = "1=1";
        }

        $request = $this->getRequest();
        $filtro_buscar = $request->query->get('filtro_buscar');
        if($filtro_buscar) {
            $this->Where .= ' AND (';
            $BuscarPorCampos = split(',', $this->BuscarPor);
            $BuscarPorNexo = '';
            foreach($BuscarPorCampos as $BuscarPorCampo) {
                $this->Where .= $BuscarPorNexo . 'r.' . $BuscarPorCampo . " LIKE '%$filtro_buscar%'";
                $BuscarPorNexo = ' OR ';
            }
            $this->Where .= ')';
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
        
        if($this->Paginar) {
            $paginator  = $this->get('knp_paginator');
            $entities = $paginator->paginate(
                $query,
                $this->getRequest()->query->get('page', 1) /* page number */,
                10 /* limit per page */
            );
        } else {
            $entities = $query->getResult();
        }
        
        return $this->ArrastrarVariables(array(
            'entities' => $entities,
        ));
    }
    
    protected function getFormType() {
        if(isset($this->FormTypeName))
            return 'Yacare\\' . $this->BundleName . 'Bundle\\Form\\' . $this->FormTypeName . 'Type';
        else
            return 'Yacare\\' . $this->BundleName . 'Bundle\\Form\\' . $this->EntityName . 'Type';
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

        $typeName = $this->getFormType();
        $editForm = $this->createForm(new $typeName(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->ArrastrarVariables(array(
            'entity'      => $entity,
            'create'      => $id ? false : true,
            'errors'      => '',
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * @Route("guardar/{id}")
     * @Route("guardar")
     * @Method("POST")
     * @Template()
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

        $errors = $this->guardarActionPreBind($entity);
        
        if(!$errors) {
            $typeName = $this->getFormType();
            $editForm = $this->createForm(new $typeName(), $entity);
            $editForm->bind($request);
            $deleteForm = $this->createDeleteForm($id);

            if ($editForm->isValid()) {
                $errors = $this->guardarActionPrePersist($entity);
                if(!$errors) {
                    $em->persist($entity);
                    $em->flush();

                    $this->get('session')->getFlashBag()->add('success', 'Los cambios en "' . $entity . '" fueron guardados.');
                }
            } else {
                $validator = $this->get('validator');
                $errors = $validator->validate($entity);
            }
        }
        
        if($errors) {
            $res = $this->ArrastrarVariables(array(
                'entity'      => $entity,
                'errors'      => $errors,
                'create'      => $id ? false : true,
                'edit_form'   => $editForm->createView(),
                'delete_form' => $deleteForm->createView()
                ));

            return $this->render('Yacare' . $this->BundleName . 'Bundle:' . $this->EntityName . ':editar.html.twig', $res);
        } else {
            return $this->redirect($this->generateUrl($this->getBaseRoute('listar'), $this->ArrastrarVariables(null, false)));
        }
    }
    
    public function guardarActionPreBind($entity)
    {
        // Función para que las clases derivadas puedan intervenir la entidad antes de bindear el formulario
        // Devuelve un array con errores o null si está todo bien
        return null;
    }
    
    public function guardarActionPrePersist($entity)
    {
        // Función para que las clases derivadas puedan intervenir la entidad antes de persistir
        // Devuelve un array con errores o null si está todo bien
        return null;
    }
    

    protected function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}

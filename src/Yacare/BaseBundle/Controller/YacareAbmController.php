<?php

namespace Yacare\BaseBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class YacareAbmController extends YacareBaseController
{
    use \Yacare\BaseBundle\Controller\ConBuscar;

    function __construct() {
        parent::__construct();

        if(!isset($this->Paginar)) {
            $this->Paginar = true;
        }
        
        if(!isset($this->OrderBy)) {
            $this->OrderBy = null;
        }
        
        if(!isset($this->Where)) {
            $this->Where = null;
        }
        
        if(!isset($this->Joins)) {
            $this->Joins = array();
        }
        
        if(!isset($this->Limit)) {
            $this->Limit = null;
        }
        
        if(!isset($this->BuscarPor)) {
            $this->BuscarPor = 'Nombre';
        }
    }
    
    protected function getSelectDql($filtro_buscar = null) {
        $dql = "SELECT r FROM Yacare" . $this->BundleName . "Bundle:" . $this->EntityName . " r";
        
        if(count($this->Joins) > 0) {
            foreach($this->Joins as $join) {
                $dql .= " " . $join;
            }
        }
        
        $where = "";
        
        if(in_array('Yacare\BaseBundle\Entity\Suprimible', class_uses('Yacare\\' . $this->BundleName . 'Bundle\Entity\\' . $this->EntityName))) {
            $where = "r.Suprimido=0";
        } else {
            $where = "1=1";
        }

        if($filtro_buscar && $this->BuscarPor) {
            // Busco por varias palabras
            // Cambio comas por espacios, quito espacios dobles y divido la cadena en los espacios
            $palabras = explode(' ', str_replace('  ', ' ', str_replace(',', ' ', $filtro_buscar)), 5);
            foreach ($palabras as $palabra) {
                $BuscarPorCampos = split(',', $this->BuscarPor);
                $BuscarPorNexo = '';
                $this->Where .= ' AND (';
                // Busco en varios campos
                foreach($BuscarPorCampos as $BuscarPorCampo) {
                    if(strpos($BuscarPorCampo, '.') === false)
                            $BuscarPorCampo = 'r.' . $BuscarPorCampo;
                    $this->Where .= $BuscarPorNexo . $BuscarPorCampo . " LIKE '%$palabra%'";
                    $BuscarPorNexo = ' OR ';
                }
                $this->Where .= ')';
            }
        }

        $dql .= " WHERE $where";
        if($this->Where) {
            $this->Where = trim($this->Where);
            if(substr($this->Where, 0, 4) != "AND ") {
                $this->Where = "AND " . $this->Where;
            }
            $dql .= ' ' . $this->Where;
        }

        if($this->OrderBy) {
            $OrderByCampos = split(',', $this->OrderBy);
            $dql .= " ORDER BY r." . join(', r.', $OrderByCampos);
        }
        
        return $dql;
    }


    /**
     * @Route("listar/")
     * @Template()
     */
    public function listarAction(Request $request)
    {
        $filtro_buscar = $request->query->get('filtro_buscar');
        $dql = $this->getSelectDql($filtro_buscar);

        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery($dql);
        
        if($this->Limit) {
            $query->setMaxResults($this->Limit);
        }
        
        if($this->Paginar) {
            $paginator  = $this->get('knp_paginator');
            $entities = $paginator->paginate(
                $query,
                $request->query->get('page', 1) /* page number */,
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
        if(isset($this->FormTypeName)) {
            return 'Yacare\\' . $this->BundleName . 'Bundle\\Form\\' . $this->FormTypeName . 'Type';
        } else {
            return 'Yacare\\' . $this->BundleName . 'Bundle\\Form\\' . $this->EntityName . 'Type';
        }
    }
    
    /**
     * @Route("ver/{id}")
     * @Template()
     */
    public function verAction($id = null)
    {
        $em = $this->getDoctrine()->getManager();

        if($id) {
            $entity = $em->getRepository('Yacare' . $this->BundleName . 'Bundle:' . $this->EntityName)->find($id);
        }

        if (!$entity) {
            throw $this->createNotFoundException('No se puede encontrar la entidad.');
        }

        return $this->ArrastrarVariables(array(
            'entity'      => $entity
        ));
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
            'delete_form' => $deleteForm ? $deleteForm->createView() : null,
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

        $typeName = $this->getFormType();
        $editForm = $this->createForm(new $typeName(), $entity);
        $editForm->handleRequest($request);
        $deleteForm = $this->createDeleteForm($id);

        $errors = $this->guardarActionPreBind($entity);

        if(!$errors) {
            if ($editForm->isValid()) {
                $errors = $this->guardarActionPrePersist($entity, $editForm);
                if(!$errors) {
                    $errors = $this->guardarActionSubirArchivos($entity, $editForm);
                }
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
            foreach ($errors as $error) {
                $this->get('session')->getFlashBag()->add('danger', $error);
            }
            
            $res = $this->ArrastrarVariables(array(
                'entity'      => $entity,
                'errors'      => $errors,
                'create'      => $id ? false : true,
                'edit_form'   => $editForm->createView(),
                'delete_form' => $deleteForm ? $deleteForm->createView() : null
                ));

            return $this->render('Yacare' . $this->BundleName . 'Bundle:' . $this->EntityName . ':editar.html.twig', $res);
        } else {
            return $this->guardarActionAfterSuccess($entity);
        }
    }
    
    
    protected function guardarActionAfterSuccess($entity) {
        return $this->redirect($this->generateUrl($this->getBaseRoute('listar'), $this->ArrastrarVariables(null, false)));
    }
    
    
    public function guardarActionPreBind($entity)
    {
        // Función para que las clases derivadas puedan intervenir la entidad antes de bindear el formulario
        // Devuelve un array con errores o null si está todo bien
        return null;
    }
    
    public function guardarActionPrePersist($entity, $editForm)
    {
        // Función para que las clases derivadas puedan intervenir la entidad antes de persistir
        // Devuelve un array con errores o null si está todo bien
        return array();
    }
    
    public function guardarActionSubirArchivos($entity, $editForm)
    {
        // Función para que las clases derivadas puedan manejar la subida de archivos
        return array();
    }
    

    protected function createDeleteForm($id)
    {
        return null;
    }
}

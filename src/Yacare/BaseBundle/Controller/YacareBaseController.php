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
        // get_class() devuelve Yacare\TalBundle\Controller\TalControlador
        // Tomo el segundo y cuarto valor (índices 1 y 3)
        $PartesNombreClase = explode('\\', get_class($this));

        if(!isset($this->BundleName)) {
            $this->BundleName = $PartesNombreClase[1];
            if(strlen($this->BundleName) > 6 && substr($this->BundleName, -6) == 'Bundle') {
                // Quitar la palabra 'Bundle' del nombre del bundle
                $this->BundleName = substr($this->BundleName, 0, strlen($this->BundleName) - 6);
            }
        }

        if(!isset($this->EntityName)) {
            $this->EntityName = $PartesNombreClase[3];
            if(strlen($this->EntityName) > 10 && substr($this->EntityName, -10) == 'Controller') {
                // Quitar la palabra 'Bundle' del nombre del bundle
                $this->EntityName = substr($this->EntityName, 0, strlen($this->EntityName) - 10);
            }
        }
        
        
        
        if(!isset($this->Paginar))
            $this->Paginar = true;
        
        if(!isset($this->OrderBy))
            $this->OrderBy = null;
        
        if(!isset($this->Where))
            $this->Where = null;
        
        if(!isset($this->BuscarPor))
            $this->BuscarPor = 'Nombre';
        
        if(!isset($this->ConservarVariables))
            $this->ConservarVariables = array();
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
                $this->get('request')->query->get('page', 1) /* page number */,
                10 /* limit per page */
            );
        } else {
            $entities = $query->getResult();
        }
        
        return $this->ArrastrarVariables(array(
            'entities' => $entities,
        ));
    }
    
    protected function ArrastrarVariables($valorInicial = null, $incluirDelSistema = true) {
        if(!$valorInicial)
            $valorInicial = array();
        
        $request = $this->getRequest();

        if($incluirDelSistema) {
            $valorInicial['bundlename']  = strtolower('yacare_' . $this->BundleName);
            $valorInicial['entityname'] = strtolower($this->EntityName);
            $valorInicial['baseroute'] = $this->getBaseRoute();
            $valorInicial['paginar'] = $this->Paginar;
        }
        
        if($this->ConservarVariables) {
            foreach($this->ConservarVariables as $vr) {
                if(!isset($valorInicial[$vr])) {
                    $valorInicial[$vr] = $request->query->get($vr);
                    $valorInicial['arrastre'][$vr] = $request->query->get($vr);
                }
            }
        }
        
        if(!isset($valorInicial['arrastre']))
            $valorInicial['arrastre'] = '';
        
        return $valorInicial;
    }
    
    
    protected function getFormType() {
        if(isset($this->FormTypeName))
            return 'Yacare\\' . $this->BundleName . 'Bundle\\Form\\' . $this->FormTypeName . 'Type';
        else
            return 'Yacare\\' . $this->BundleName . 'Bundle\\Form\\' . $this->EntityName . 'Type';
    }
    
    // Devuelve el nombre de la ruta para una acción determinada o la base para conformar las rutas
    protected function getBaseRoute($action = null) {
        if($action)
            return strtolower('yacare_' . $this->BundleName . '_' . $this->EntityName . '_' . $action);
        else
            return strtolower('yacare_' . $this->BundleName . '_' . $this->EntityName);
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

        $this->guardarActionPreBind($entity);
        
        $typeName = $this->getFormType();
        $editForm = $this->createForm(new $typeName(), $entity);
        $editForm->bind($request);
        $deleteForm = $this->createDeleteForm($id);

        if ($editForm->isValid()) {
            $this->guardarActionPrePersist($entity);
            $em->persist($entity);
            $em->flush();
            
            $this->get('session')->getFlashBag()->add('success', 'Los cambios en "' . $entity . '" fueron guardados.');
            //return null;
            return $this->redirect($this->generateUrl($this->getBaseRoute('listar'), $this->ArrastrarVariables(null, false)));
        } else {
            $validator = $this->get('validator');
            $errors = $validator->validate($entity);

            $res = $this->ArrastrarVariables(array(
                'entity'      => $entity,
                'errors'      => $errors,
                'create'      => $id ? false : true,
                'edit_form'   => $editForm->createView(),
                'delete_form' => $deleteForm->createView()
                ));

            return $this->render('Yacare' . $this->BundleName . 'Bundle:' . $this->EntityName . ':editar.html.twig', $res);
        }
    }
    
    public function guardarActionPreBind($entity)
    {
        // Función para que las clases derivadas puedan intervenir la entidad antes de bindear el formulario
    }
    
    public function guardarActionPrePersist($entity)
    {
        // Función para que las clases derivadas puedan intervenir la entidad antes de persistir
    }
    

    protected function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}

<?php
namespace Tapir\BaseBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Controlador base para listados, altas, bajas y ediciones.
 *
 * Controlador abstracto del cual derivan todos los controladores de ABM.
 * Implementa métodos genéricos para realizar listados (listar), altas (crear y
 * guardar), bajas (eliminar y eliminar2) y modificaciones (editar y guardar).
 *
 * @abstract
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
abstract class AbmController extends BaseController
{
    // use \Tapir\BaseBundle\Controller\ConBuscar;
    function IniciarVariables()
    {
        parent::IniciarVariables();
        
        if (! isset($this->Paginar)) {
            $this->Paginar = true;
        }
        
        if (! isset($this->OrderBy)) {
            if (\Tapir\BaseBundle\Helper\ClassHelper::UsaTrait($this->CompleteEntityName, 
                'Tapir\BaseBundle\Entity\ConNombre')) {
                $this->OrderBy = 'Nombre';
            } else {
                $this->OrderBy = null;
            }
        }
        
        if (! isset($this->Where)) {
            $this->Where = null;
        }
        
        if (! isset($this->GroupBy)) {
            $this->GroupBy = null;
        }
        
        if (! isset($this->Joins)) {
            $this->Joins = array();
        }
        
        if (! isset($this->ExtraFields)) {
            $this->ExtraFields = array();
        }
        
        if (! isset($this->Limit)) {
            $this->Limit = null;
        }
        
        if (! isset($this->BuscarPor)) {
            $this->BuscarPor = 'Nombre';
        }
    }

    /**
     * Obtiene la cantidad de registros del listado.
     * 
     * @see listarAction()
     * @see obtenerComandoSelect()
     * @return int Cantidad de registros.
     */
    public function obtenerCantidadRegistros($whereAdicional = null)
    {
        $dql = $this->obtenerComandoSelect(null, true, $whereAdicional);
        
        $em = $this->getEm();
        $query = $em->createQuery($dql);
        $cant = $query->getSingleScalarResult();
        
        return $cant;
    }

    /**
     * Genera la consulta DQL para el listado.
     *
     * La consulta generada contiene los JOIN y ORDER BY correspondiente además
     * de la cláusula WHERE que incluye las condiciones predeterminadas y la
     * condición Suprimido=0 para los elementos suprimibles (soft-delete) y las
     * condiciones de páginación y búsqueda (esta última si el parámetro
     * $filtro_buscar no es null).
     *
     * @see listarAction()
     * @see $Joins
     * @see $Where
     * @see $OrderBy
     * @see $BuscarPor
     * @see $Limit
     * @see $Paginar
     *
     * @param string $filtro_buscar
     *            El filtro a aplicar en formato DQL.
     * @return string Una comando DQL SELECT para obtener el listado.
     */
    protected function obtenerComandoSelect($filtro_buscar = null, $soloContar = false, $whereAdicional = null)
    {
        $dql = "SELECT ";
        if ($soloContar) {
            $dql .= "COUNT(r) AS cant";
        } else {
            $dql .= "r";
            if ($this->ExtraFields) {
                $dql .= ", " . join(', ', $this->ExtraFields);
            }
        }
        $dql .= " FROM " . $this->CompleteEntityName . " r";
        
        if (count($this->Joins) > 0) {
            $this->Joins = array_unique($this->Joins);
            foreach ($this->Joins as $join) {
                $dql .= " " . $join;
            }
        }
        
        $where = "";
        
        if (\Tapir\BaseBundle\Helper\ClassHelper::UsaTrait($this->CompleteEntityName, 
            'Tapir\BaseBundle\Entity\Suprimible')) {
            $where = "r.Suprimido=0";
        } else {
            $where = "1=1";
        }
        
        if ($filtro_buscar && $filtro_buscar != '%' && $this->BuscarPor) {
            // Busco por varias palabras
            // Cambio comas por espacios, quito espacios dobles y divido la cadena en los espacios
            $palabras = explode(' ', str_replace('  ', ' ', str_replace(',', ' ', $filtro_buscar)), 5);
            foreach ($palabras as $palabra) {
                $BuscarPorCampos = explode(',', $this->BuscarPor);
                $BuscarPorNexo = '';
                $this->Where .= ' AND (';
                // Busco en varios campos
                foreach ($BuscarPorCampos as $BuscarPorCampo) {
                    if (strpos($BuscarPorCampo, '.') === false)
                        $BuscarPorCampo = 'r.' . $BuscarPorCampo;
                    $this->Where .= $BuscarPorNexo . $BuscarPorCampo . " LIKE '%$palabra%'";
                    $BuscarPorNexo = ' OR ';
                }
                $this->Where .= ')';
            }
        }
        
        $dql .= " WHERE $where";
        
        if ($this->Where) {
            $this->Where = trim($this->Where);
            if (substr($this->Where, 0, 4) != "AND ") {
                $this->Where = "AND " . $this->Where;
            }
            $dql .= ' ' . $this->Where;
        }
        
        if ($whereAdicional) {
            $whereAdicional = trim($whereAdicional);
            if (substr($whereAdicional, 0, 4) != "AND ") {
                $whereAdicional = "AND " . $whereAdicional;
            }
            $dql .= ' ' . $whereAdicional;
        }
        
        if ($this->GroupBy) {
            $dql .= ' GROUP BY ' . $this->GroupBy;
        }
        
        if ($this->OrderBy && $soloContar == false) {
            $OrderByCampos = explode(',', $this->OrderBy);
            $OrderByCamposConTabla = array();
            
            foreach ($OrderByCampos as $Campo) {
                // Agrego "r." a los campos que no especifican una tabla
                if (strpos($Campo, '.') === false) {
                    $Campo = 'r.' . $Campo;
                } elseif (substr($Campo, 0, 1) == '.') {
                    $Campo = substr($Campo, 1);
                }
                $OrderByCamposConTabla[] = $Campo;
            }
            $dql .= " ORDER BY " . join(', ', $OrderByCamposConTabla);
        }
        
        //echo '------------------------------------------------------------------- ' . $dql;
        
        return $dql;
    }

    /**
     * Obtiene el listado de entidades.
     *
     * Utiliza las condiciones de límites y paginación y devuelve un array()
     * con las entidades a listar.
     *
     * @see obtenerComandoSelect()
     * @Route("listar/")
     * @Template()
     */
    public function listarAction(Request $request)
    {
        $filtro_buscar = $this->ObtenerVariable($request, 'filtro_buscar');
        $dql = $this->obtenerComandoSelect($filtro_buscar);
        
        $em = $this->getEm();
        $query = $em->createQuery($dql);
        
        // echo '<pre>' . $dql . '</pre>';
        
        if ($this->Limit) {
            $query->setMaxResults($this->Limit);
        }
        
        if ($this->Paginar) {
            $paginator = $this->get('knp_paginator');
            $entities = $paginator->paginate($query, $request->query->get('page', 1) /* page number */,
                50 /* limit per page */
            );
        } else {
            $entities = $query->getResult();
        }
        
        return $this->ArrastrarVariables($request, array('entities' => $entities));
    }

    /**
     * Obtiene el nombre del tipo de formulario (FormType) que corresponde a la entidad
     * administrada por este controlador.
     *
     * @return string El nombre del tipo de formulario.
     */
    protected function obtenerFormType()
    {
        if (isset($this->FormTypeName)) {
            return $this->VendorName . '\\' . $this->BundleName . 'Bundle\\Form\\' . $this->FormTypeName . 'Type';
        } else {
            return $this->VendorName . '\\' . $this->BundleName . 'Bundle\\Form\\' . $this->EntityName . 'Type';
        }
    }

    /**
     * Pantalla de inicio.
     *
     * Cada controlador puede implementar ad libitum.
     *
     * @Route("inicio/")
     * @Template()
     */
    public function inicioAction(Request $request)
    {
        return $this->ArrastrarVariables($request, array());
    }

    /**
     * Ver una entidad.
     *
     * Es como editar, pero sólo lectura.
     *
     * @see editarAction()
     * @Route("ver/{id}")
     * @Template()
     */
    public function verAction(Request $request, $id = null)
    {
        if (! $id) {
            $id = $this->ObtenerVariable($request, 'id');
        }
        
        if ($id) {
            $entity = $this->obtenerEntidadPorId($id);
        }
        
        if (! $entity) {
            throw $this->createNotFoundException('No se puede encontrar la entidad.');
        }
        
        return $this->ArrastrarVariables($request, array('entity' => $entity));
    }
    
    
    /**
     * Permite modificar un campo in situ.
     * 
     * Recibe el nombre del campo y el ID de la entidad y muestra un textbox.
     *
     * @Route("editarcampo/{nombrecampo}/{id}")
     * @Template("TapirBaseBundle:Default:editarcampo.html.twig")
     */
    public function editarcampoAction(Request $request, $nombrecampo, $id)
    {
        $em = $this->getEm();
    
        if ($id) {
            $entity = $this->obtenerEntidadPorId($id);
        }
    
        if (! $entity) {
            throw $this->createNotFoundException('No se puede encontrar la entidad.');
        }
        
        $DataControl = $this->ObtenerVariable($request, 'data-control');
        if(!$DataControl) {
            $DataControl = 'text';
        }
        
        $NombreGetter = 'get' . $nombrecampo;
        $ValorActual = $entity->$NombreGetter();
        $NuevoValor = $this->ObtenerVariable($request, 'nuevoValor');
        if($NuevoValor) {
            $NombreSetter = 'set' . $nombrecampo;
            $entity->$NombreSetter($NuevoValor);
            $em->persist($entity);
            $em->flush();
        } 
        
        return $this->ArrastrarVariables($request,
            array(
                'entity' => $entity,
                'errors' => '',
                'data_control' => $DataControl,
                'nombrecampo' => $nombrecampo,
                'valoractual' => $ValorActual,
                'nuevovalor' => $NuevoValor,
                'id' => $id
                ));
    }
    
    

    /**
     * Inicia la edición o creación de una entidad.
     *
     * Recibe el ID de la entidad a editar o null en caso de crear una nueva
     * (alta). Devuelve la entidad actual (desde la base de datos) o la entidad
     * nueva (creada con el método crearNuevaEntidad) y el formulario de edición
     *
     * @see crearNuevaEntidad()
     * @see guardarAction()
     *
     * @param \Symfony\Component\HttpFoundation\Request $request            
     * @param int $id
     *            El ID de la entidad a editar, o null si se trata de un
     *            alta.
     *            
     *            @Route("editar/{id}")
     *            @Route("crear/")
     *            @Template()
     */
    public function editarAction(Request $request, $id = null)
    {
        if ($id) {
            $entity = $this->obtenerEntidadPorId($id);
        } else {
            $entity = $this->crearNuevaEntidad($request);
        }
        
        if (! $entity) {
            throw $this->createNotFoundException('No se puede encontrar la entidad.');
        }
        
        $typeName = $this->obtenerFormType();
        $editForm = $this->createForm(new $typeName(), $entity);
        $deleteForm = $this->crearFormEliminar($id);
        
        return $this->ArrastrarVariables($request, 
            array(
                'entity' => $entity,
                'create' => $id ? false : true,
                'errors' => '',
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm ? $deleteForm->createView() : null));
    }

    /**
     * Guarda los cambios en la entidad.
     *
     * Recibe el formulario de alta o de edición y persiste los cambios en la
     * base de datos o vuelve al formulario con una lista de errores.
     *
     * @see editarAction()
     * @param \Symfony\Component\HttpFoundation\Request $request
     * 
     * @Route("guardar/{id}")
     * @Route("guardar")
     * @Method("POST")
     * @Template()
     */
    public function guardarAction(Request $request, $id = null)
    {
        $em = $this->getEm();
        
        if ($id) {
            $entity = $this->obtenerEntidadPorId($id);
        } else {
            $entity = $this->crearNuevaEntidad($request);
        }
        
        if (! $entity) {
            throw $this->createNotFoundException('No se puede encontrar la entidad.');
        }
        
        $typeName = $this->obtenerFormType();
        $editForm = $this->createForm(new $typeName(), $entity);
        $editForm->handleRequest($request);
        
        $errors = $this->guardarActionPreBind($entity);
        
        if (! $errors) {
            if ($editForm->isValid()) {
                $errors = $this->guardarActionPrePersist($entity, $editForm);
                if (! $errors) {
                    $errors = $this->guardarActionSubirArchivos($entity, $editForm);
                }
                if (! $errors) {
                    $em->persist($entity);
                    $em->flush();
                    $this->guardarActionPostPersist($entity, $editForm);
                    
                    $this->addFlash('success', 'Los cambios en "' . $entity . '" fueron guardados.');
                }
            } else {
                $validator = $this->get('validator');
                $errors = $validator->validate($entity);
            }
        }
        
        if ($errors) {
            $deleteForm = $this->crearFormEliminar($id);
            
            foreach ($errors as $error) {
                $this->addFlash('danger', $error);
            }
            
            $res = $this->ArrastrarVariables($request, 
                array(
                    'entity' => $entity,
                    'errors' => $errors,
                    'create' => $id ? false : true,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm ? $deleteForm->createView() : null));
            
            return $this->render(
                $this->VendorName . $this->BundleName . 'Bundle:' . $this->EntityName . ':editar.html.twig', $res);
        } else {
            return $this->guardarActionAfterSuccess($request, $entity);
        }
    }

    protected function guardarActionAfterSuccess(Request $request, $entity)
    {
        return $this->redirectToRoute($this->obtenerRutaBase('listar'), $this->ArrastrarVariables($request, null, false));
    }

    public function guardarActionPreBind($entity)
    {
        // Función para que las clases derivadas puedan intervenir la entidad antes de bindear el formulario
        // Devuelve un array con errores o null si está todo bien
        return null;
    }

    /**
     * Función para que las clases derivadas puedan intervenir la entidad antes de persistirla.
     *
     * @return array Devuelve un array con errores o null si está todo bien
     */
    public function guardarActionPrePersist($entity, $editForm)
    {
        return array();
    }

    /**
     * Función para que las clases derivadas puedan intervenir la entidad después de persistirla.
     */
    public function guardarActionPostPersist($entity, $editForm)
    {
        return;
    }

    /**
     * Función para que las clases derivadas puedan manejar la subida de archivos.
     */
    public function guardarActionSubirArchivos($entity, $editForm)
    {
        return array();
    }

    /**
     * Crear el formulario de eliminar.
     *
     * Está en blanco ya que se espera que sea implementada por ConEliminar.
     *
     * @see ConEliminar
     */
    protected function crearFormEliminar($id)
    {
        return null;
    }

    /**
     * Crea una entidad nueva.
     *
     * Crea una entidad nueva. Permite a los controladores derivados intervenir
     * la creación de las entidades durante el procedo de alta.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request            
     * @return object La entidad nueva.
     */
    protected function crearNuevaEntidad(Request $request)
    {
        $entityName = $this->CompleteEntityName;
        $entity = new $entityName();
        return $entity;
    }

    /**
     * Obtiene una entidad de la base de datos mediante su Id.
     *
     * Permite a los controladores derivados intervenir la obtención de
     * entidades durante los procesos de edición, eliminación, archivado, etc.
     *
     * @param
     *            integer
     * @return object La entidad.
     */
    protected function obtenerEntidadPorId($id)
    {
        $em = $this->getEm();
        return $em->getRepository($this->CompleteEntityName)->find($id);
    }
}

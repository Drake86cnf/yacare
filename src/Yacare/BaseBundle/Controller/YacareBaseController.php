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
        $PartesNombreClase = explode('\\', get_class());
        $BundleName = $PartesNombreClase[1];
        $ClassName = $PartesNombreClase[3];
        
        if(strlen($this->BundleName) > 6 && substr($this->BundleName, -6) == 'Bundle')
                // Quitar la palabra 'Bundle' del nombre del bundle
                $this->BundleName = substr($this->BundleName, 0, strlen($this->BundleName) - 6);
        
        $this->UsePaginator = true;
        
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
        
        if(in_array('Yacare\BaseBundle\Entity\Eliminable', class_uses('Yacare\\' . $this->BundleName . 'Bundle\Entity\\' . $this->EntityName))) {
            $where = "r.Eliminado=0";
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
    
    
    private function getFormType() {
        if(isset($this->FormTypeName))
            return 'Yacare\\' . $this->BundleName . 'Bundle\\Form\\' . $this->FormTypeName . 'Type';
        else
            return 'Yacare\\' . $this->BundleName . 'Bundle\\Form\\' . $this->EntityName . 'Type';
    }
    
    
    
    /**
     * @Route("imprimir/{id}")
     * @Template()
     */
    public function imprimirAction($id)
    {
        $request = $this->getRequest();
        $fmt = $request->query->get('fmt');
        if(!$fmt)
            $fmt = 'application/pdf';
        
        $fmt = str_replace(' ', '/', $fmt);
        
        $tpl = $request->query->get('tpl');
        if(!$tpl)
            $tpl = 'imprimir';
        
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('Yacare' . $this->BundleName . 'Bundle:' . $this->EntityName)->find($id);
        if (!$entity)
            throw $this->createNotFoundException('No se puede encontrar la entidad.');

        $impresionEnCache = $em->getRepository('YacareBaseBundle:Impresion')->findBy(array(
            'EntidadTipo' => $this->BundleName . '/' . $this->EntityName,
            'EntidadId' => $entity->getId(),
            'EntidadVersion' => $entity->getVersion(),
            'TipoMime' => $fmt
        ));

        if(!$impresionEnCache) {
            // La impresión NO está en caché... la genero y la guardo en el cache
            // en principio la guardo sin contenido (placeholder), para obtener un id
            $impresionEnCache = new \Yacare\BaseBundle\Entity\Impresion();
            $impresionEnCache->setEntidadTipo($this->BundleName . '/' . $this->EntityName);
            $impresionEnCache->setEntidadId($entity->getId());
            $impresionEnCache->setEntidadVersion($entity->getVersion());
            $impresionEnCache->setTipoMime($fmt);
            $impresionEnCache->setContenido('placeholder');
            $em->persist($impresionEnCache);
            $em->flush();
            $em->refresh($impresionEnCache);

            // Ahora genero el contenido y guardo nuevamente la impresión
            $html = $this->renderView('Yacare' . $this->BundleName . 'Bundle:' . $this->EntityName . ':' . $tpl . '.html.twig', array(
                'id'       => $id,
                'entity'   => $entity,
                'impresion'=> $impresionEnCache,
                'fmt'      => 'text/html',
                'tpl'      => $tpl
            ));

            $impresionEnCache->setImagen($this->get('knp_snappy.image')->getOutputFromHtml($html));
            switch($fmt) {
                case 'text/html':
                    $impresionEnCache->setContenido($html);
                    break;
                case 'application/pdf':
                    $impresionEnCache->setContenido($this->get('knp_snappy.pdf')->getOutputFromHtml($html));
                    break;
            }

            $em->persist($impresionEnCache);
            $em->flush();
        } else {
            if(is_array($impresionEnCache))
                $impresionEnCache = $impresionEnCache[0];
        }

        $contenido = $impresionEnCache->getContenido();
        if(is_resource($contenido) && get_resource_type($contenido) == 'stream')
            $contenido = stream_get_contents($contenido);

        return new \Symfony\Component\HttpFoundation\Response(
            $contenido,
            200,
            array(
                'Content-Type'          => $impresionEnCache->getTipoMime(),
                'Content-Length'        => strlen($contenido),
                'Content-Disposition'   => 'filename="' . $this->EntityName . '_' . $entity->getId() . '.pdf"'
            )
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

        $typeName = $this->getFormType();
        $editForm = $this->createForm(new $typeName(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'create'      => $id ? false : true,
            'errors'      => '',
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
            return $this->redirect($this->generateUrl(strtolower('yacare_' . $this->BundleName . '_' . $this->EntityName . '_listar')));
        } else {
             $validator = $this->get('validator');
             $errors = $validator->validate($entity);
             
             print_r($errors);

             return $this->render('Yacare' . $this->BundleName . 'Bundle:' . $this->EntityName . ':editar.html.twig', array(
                'entity'      => $entity,
                'errors'      => $errors,
                'create'      => $id ? false : true,
                'edit_form'   => $editForm->createView(),
                'delete_form' => $deleteForm->createView()
                )
            );
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
                $this->get('session')->getFlashBag()->add('notice', 'Se eliminó el elemento "' . $entity . '".');
            } else {
                // Lo elimino de verdad
                //$em->remove($entity);
                $this->get('session')->getFlashBag()->add('notice', 'No se eliminó el elemento "' . $entity . '".');
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

    
    /**
     * @Route("qr/{id}")
     */
    public function qrAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('Yacare' . $this->BundleName . 'Bundle:' . $this->EntityName)->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Document entity.');
        }
        
        $ContenidoQr = $entity->getYri(true);

        ob_start();
        \PHPQRCode\QRcode::png($ContenidoQr);
        $imagen_contenido = ob_get_contents();
        ob_end_clean();
        
        $response = new \Symfony\Component\HttpFoundation\Response($imagen_contenido, 200, array(
            'Content-Type' => 'image/png',
            'Content-Length' => strlen($imagen_contenido),
            'Content-Disposition' => 'filename="' . 'Yacare' . $this->BundleName . 'Bundle_' . $this->EntityName . '_' . $entity->getId() . '.png"',
        ));

        return $response;
    }
}

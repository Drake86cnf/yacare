<?php

namespace Yacare\InspeccionBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("relevamientoasignacion/")
 */
class RelevamientoAsignacionController extends \Yacare\BaseBundle\Controller\YacareBaseController
{
    function __construct() {
        $this->BundleName = 'Inspeccion';
        $this->EntityName = 'RelevamientoAsignacion';
        $this->UsePaginator = true;
        parent::__construct();
    }
    
    
    /**
     * @Route("asignarcalle/{id}")
     * @Template()
     */
    public function asignarcalleAction($id = null)
    {
        $em = $this->getDoctrine()->getManager();

        $entityName = 'Yacare\\' . $this->BundleName . 'Bundle\\Entity\\' . $this->EntityName;
        $entity = new $entityName();

        if (!$entity) {
            throw $this->createNotFoundException('No se puede encontrar la entidad.');
        }

        $typeName = 'Yacare\\' . $this->BundleName . 'Bundle\\Form\\' . $this->EntityName . 'CalleType';
        $editForm = $this->createForm(new $typeName(), $entity);
        //$deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'create'      => true,
            'id'          => $id,
            'edit_form'   => $editForm->createView()
        );
    }
    

    /**
     * @Route("asignarmacizo/{id}")
     * @Template()
     */
    public function asignarmacizoAction($id = null)
    {
        $em = $this->getDoctrine()->getManager();

        $entityName = 'Yacare\\' . $this->BundleName . 'Bundle\\Entity\\' . $this->EntityName;
        $entity = new $entityName();

        if (!$entity) {
            throw $this->createNotFoundException('No se puede encontrar la entidad.');
        }

        $typeName = 'Yacare\\' . $this->BundleName . 'Bundle\\Form\\' . $this->EntityName . 'MacizoType';
        $editForm = $this->createForm(new $typeName(), $entity);

        return array(
            'entity'      => $entity,
            'create'      => true,
            'id'          => $id,
            'edit_form'   => $editForm->createView()
        );
    }
}

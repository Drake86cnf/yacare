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
     * @Route("relevamiento/{relevamiento}")
     * @Template()
     */
    public function relevamientoAction($relevamiento)
    {
        return parent::listarAction();
    }
    
    
    /**
     * @Route("guardar/{id}")
     * @Route("guardar")
     * @Method("POST")
     * @Template("YacareInspeccionBundle:RelevamientoAsignacion:asignarcalle.html.twig")
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
        $editForm = $this->createForm(new $typeName(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            
            // ************************* Guardar detalles
            if($entity->getCalle()) {
                // Es por calle
                $partidas = $em->getRepository('YacareCatastroBundle:Partida')->findBy(array('Calle' => $entity->getCalle()));
            } else {
                // Es por S-M-P
                $partidas = $em->getRepository('YacareCatastroBundle:Partida')->findBy(array('Seccion' => $entity->getSeccion(), 'MacizoNum' => $entity->getMacizo()));
            }

            $total_partidas = 0;
            if($partidas) {
                foreach ($partidas as $partida) {
                    $total_partidas++;
                    $Deta = new \Yacare\InspeccionBundle\Entity\RelevamientoAsignacionDetalle();
                    $Deta->setAsignacion($entity);
                    $Deta->setEncargado($entity->getEncargado());
                    $Deta->setRelevamiento($entity->getRelevamiento());
                    $Deta->setPartida($partida);
                    $Deta->setPartidaCalle($partida->getCalle());
                    $Deta->setPartidaCalleNumero($partida->getCalleNumero());
                    $Deta->setPartidaSeccion($partida->getSeccion());
                    $Deta->setPartidaMacizo($partida->getMacizoNum() . $partida->getMacizoAlfa());
                    $Deta->setPartidaParcela($partida->getParcelaNum() . $partida->getParcelaAlfa());

                    $em->persist($Deta);
                }
            }
            // ************************* /
            
            $em->flush();

            return $this->redirect($this->generateUrl(strtolower('yacare_' . $this->BundleName . '_' . $this->EntityName . '_listar')));
        }

        //$this->setTemplate('Yacare' . $this->BundleName . 'Bundle:' . $this->EntityName . ':edit.html.twig');
        return array(
            'entity'      => $entity,
            'create'      => true,
            'id'          => $id,
            'edit_form'   => $editForm->createView()
        );
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

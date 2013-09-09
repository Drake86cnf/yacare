<?php

namespace Yacare\InspeccionBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("relevamientoasignacion/")
 */
class RelevamientoAsignacionController extends \Yacare\BaseBundle\Controller\YacareAbmController
{
    function __construct() {
        $this->BundleName = 'Inspeccion';
        $this->EntityName = 'RelevamientoAsignacion';
        parent::__construct();
    }

    /**
     * @Route("listarrelevamiento/{id}")
     * @Template("YacareInspeccionBundle:RelevamientoAsignacion:listar.html.twig")
     */
    public function listarrelevamientoAction($id)
    {
        $res = parent::listarAction();
        $res['id'] = $id;
        
        return $res;
    }
    
    /**
     * @Route("cancelar/{id}")
     * @Route("cancelar")
     * @Template("YacareInspeccionBundle:RelevamientoAsignacion:cancelar.html.twig")
     */
    public function cancelarAction($id=null, $confirma=FALSE)
    {
        if($confirma)  {
            return $this->redirect($this->generateUrl(strtolower('yacare_' . $this->BundleName . '_' . $this->EntityName . '_listar')));
        }
        
        return array(
            'id'      => $id,
            );
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
                $partidas = $em->getRepository('YacareCatastroBundle:Partida')->findBy(array('Seccion' => $entity->getSeccion(), 'Macizo' => $entity->getMacizo()));
            }

            if($partidas) {
                /* $numDeleted = $em->createQuery('DELETE FROM YacareInspeccionBundle:RelevamientoAsignacionDetalle r WHERE r.Asignacion = :asignacion_id AND r.ResultadosCantidad=0')
                    ->setParameter('asignacion_id', $entity->getId())
                    ->execute(); */
                
                //Marco los resultados en blanco actuales como cancelados
                $numDeleted = $em->createQuery('UPDATE YacareInspeccionBundle:RelevamientoAsignacionDetalle r SET r.Suprimido=1 WHERE r.Asignacion = :asignacion_id AND r.ResultadosCantidad = 0')
                    ->setParameter('asignacion_id', $entity->getId())
                    ->execute();
                
                $DetallesCantidad = 0;
                foreach ($partidas as $partida) {
                    $DetallesCantidad++;
                    $Deta = new \Yacare\InspeccionBundle\Entity\RelevamientoAsignacionDetalle();
                    $Deta->setAsignacion($entity);
                    $Deta->setEncargado($entity->getEncargado());
                    $Deta->setRelevamiento($entity->getRelevamiento());
                    $Deta->setPartida($partida);
                    $Deta->setPartidaCalle($partida->getCalle());
                    $Deta->setPartidaCalleNombre($partida->getCalle());
                    $Deta->setPartidaCalleNumero($partida->getCalleNumero());
                    $Deta->setPartidaSeccion($partida->getSeccion());
                    $Deta->setPartidaMacizo($partida->getMacizoNum() . $partida->getMacizoAlfa());
                    $Deta->setPartidaParcela($partida->getParcelaNum() . $partida->getParcelaAlfa());

                    $em->persist($Deta);
                }
                
                $entity->setDetallesCantidad($DetallesCantidad);
                $em->persist($entity);
                
                //$numDeleted = $em->createQuery('DELETE FROM YacareInspeccionBundle:RelevamientoAsignacionDetalle r WHERE r.Asignacion = :asignacion_id AND r.ResultadosCantidad>0')
                //   ->setParameter('asignacion_id', $entity->getId())
                //   ->execute();

            }
            // ************************* /
            
            $em->flush();

            return $this->redirect($this->generateUrl(strtolower('yacare_' . $this->BundleName . '_' . $this->EntityName . '_listarrelevamiento'), array('id' => $entity->getRelevamiento()->getId())));
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

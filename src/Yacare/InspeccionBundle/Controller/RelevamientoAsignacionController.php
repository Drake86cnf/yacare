<?php

namespace Yacare\InspeccionBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Controlador de asignaciones.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 *
 * @Route("relevamientoasignacion/")
 */
class RelevamientoAsignacionController extends \Yacare\BaseBundle\Controller\YacareAbmController
{
    use \Yacare\BaseBundle\Controller\ConEliminar;
    
    function __construct() {
        $this->ConservarVariables[] = 'filtro_relevamiento';
        
        parent::__construct();
    }
    
    
    /**
     * @Route("listar/")
     * @Template()
     */
    public function listarAction(Request $request) {
        $filtro_relevamiento = $request->query->get('filtro_relevamiento');
        
        if($filtro_relevamiento) {
            $this->Where .= " AND r.Relevamiento=$filtro_relevamiento";
        }
        
        return parent::listarAction($request);
    }

    /**
     * @Route("listarrelevamiento/{id}")
     * @Template("YacareInspeccionBundle:RelevamientoAsignacion:listar.html.twig")
     */
    public function listarrelevamientoAction(Request $request, $id)
    {
        $res = parent::listarAction($request);
        $res['id'] = $id;
        
        return $res;
    }
    
    
    public function afterEliminar($entity, $eliminado = false)
    {
        return $this->redirect($this->generateUrl($this->obtenerRutaBase('listar'), $this->ArrastrarVariables(array('filtro_relevamiento' => $entity->getRelevamiento()->getId()), false)));
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
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            
            // ************************* Guardar detalles
            if($entity->getCalle()) {
                // Es por calle
                $partidas = $em->getRepository('YacareCatastroBundle:Partida')->findBy(array('DomicilioCalle' => $entity->getCalle()));
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
                    $Deta->setPartidaCalle($partida->getDomicilioCalle());
                    $Deta->setPartidaCalleNombre($partida->getDomicilioCalle()->getNombre());
                    $Deta->setPartidaCalleNumero($partida->getDomicilioNumero());
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

            return $this->redirect($this->generateUrl(strtolower('yacare_' . $this->BundleName . '_' . $this->EntityName . '_listar'), array('filtro_relevamiento' => $entity->getRelevamiento()->getId())));
        }

        //$this->setTemplate('Yacare' . $this->BundleName . 'Bundle:' . $this->EntityName . ':edit.html.twig');
        return $this->ArrastrarVariables(array(
            'entity'      => $entity,
            'create'      => true,
            'edit_form'   => $editForm->createView()
        ));
    }
    
    
    /**
     * @Route("asignarcalle/")
     * @Template()
     */
    public function asignarcalleAction(Request $request)
    {
        $filtro_relevamiento = $request->query->get('filtro_relevamiento');
        $em = $this->getDoctrine()->getManager();

        $entity = $this->crearNuevaEntidad($request);

        if (!$entity) {
            throw $this->createNotFoundException('No se puede crear la entidad.');
        }
        
        $entity->setRelevamiento($em->getReference('YacareInspeccionBundle:Relevamiento', $filtro_relevamiento));

        $typeName = 'Yacare\\' . $this->BundleName . 'Bundle\\Form\\' . $this->EntityName . 'CalleType';
        $editForm = $this->createForm(new $typeName(), $entity);
        //$deleteForm = $this->crearFormEliminar($id);

        return $this->ArrastrarVariables(array(
            'entity'      => $entity,
            'create'      => true,
            'edit_form'   => $editForm->createView()
        ));
    }
    

    /**
     * @Route("asignarmacizo/")
     * @Template()
     */
    public function asignarmacizoAction(Request $request)
    {
        $filtro_relevamiento = $request->query->get('filtro_relevamiento');
        $em = $this->getDoctrine()->getManager();

        $entity = $this->crearNuevaEntidad($request);

        if (!$entity) {
            throw $this->createNotFoundException('No se puede crear la entidad.');
        }
        
        $entity->setRelevamiento($em->getReference('YacareInspeccionBundle:Relevamiento', $filtro_relevamiento));

        $typeName = 'Yacare\\' . $this->BundleName . 'Bundle\\Form\\' . $this->EntityName . 'MacizoType';
        $editForm = $this->createForm(new $typeName(), $entity);
        
        return $this->ArrastrarVariables(array(
            'entity'      => $entity,
            'create'      => true,
            'edit_form'   => $editForm->createView()
        ));
    }
}

<?php
namespace Yacare\InspeccionBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Agrega la capacidad de agregar o cancelar turnos en entidades que definen turnos.
 *
 * @author Diaz Alejandro <alediaz.rc@gmail.com>
 * 
 * @see \Yacare\InspeccionBundle\Entity\ConTurno
 */
trait ConTurno
{

    /**
     * @Route("turno/")
     * @Template("YacareInspeccionBundle:ConTurno:turno.html.twig")
     */
    public function turnoAction(Request $request)
    {
        $id = $this->ObtenerVariable($request, 'id');
        $em = $this->getDoctrine()->getManager();
        $entity = $this->ObtenerEntidadPorId($id);
        
        $FormEditarBuilder = $this->createFormBuilder($entity);
        
        $FormEditarBuilder ->add('TurnoFecha', null, array(
            'date_widget' => 'choice',
            'time_widget' => 'choice',
            'date_format' => 'dd.MM.yyyy',
            'data' => new \DateTime('now'), 
            'required' => true,
        ));
        $FormEditarBuilder->add('TurnoEstado', '\Tapir\BaseBundle\Form\Type\ButtonGroupType',
            array('label' => 'Estado del turno', 'required' => true,
                'choices' => array(
                    'Sin turno' =>-1,
                    'Activo' => 0 ,
                    'Terminado' => 1,
                    'Cancelado' => 2,
                    'Vencido' => 3,
                )));
        $FormEditar = $FormEditarBuilder->getForm();
        $FormEditar->handleRequest($request);
        
        
        if ($FormEditar->isValid()) {
            // Invertir el estado y guardar.
            if ($entity->getTurnoEstado()) {
                $entity->getTurnoFecha();
            } else {
                $fechaturno = "0000/00/00";
                $horaturno= "00:00:00";
                $entity->setFechaTurno($fechaturno);
                $entity->setHoraTurno($horaturno);
                $entity->setTurnoEstado("Activo");
            }
            $em->persist($entity);
            $em->flush();
            return $this->guardarActionAfterSuccess($request, $entity);
        } else {
            $res = $this->ConstruirResultado(new \Tapir\AbmBundle\Helper\Resultados\ResultadoEditarGuardarAction($this), 
                $request);
            $res->Entidad = $entity;
            $res->FormularioEditar = $FormEditar->createView();
            $res->AccionGuardar = 'turno';
            return array('res' => $res);
        }
    }
  
}

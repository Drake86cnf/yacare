<?php
namespace Yacare\ComercioBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Controlador de trámite habilitación comercial.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 *
 * @Route("tramitehabilitacioncomercial/")
 */
class TramiteHabilitacionComercialController extends \Yacare\TramitesBundle\Controller\TramiteController
{
    use \Yacare\RequerimientosBundle\Controller\ConMailer;
    
    public function EmitirComprobante($tramite)
    {
        $Comprob = parent::EmitirComprobante($tramite);

        $Comprob->setComercio($tramite->getComercio());
        $Comprob->setTitular($tramite->getTitular());
        $tramite->getComercio()->setEstado(100);
        $tramite->getComercio()->setCertificadoHabilitacion($Comprob);

        return $Comprob;
    }

    /**
     * @Route("consultar")
     * @Template()
     */
    public function consultarAction(Request $request)
    {
        $em = $this->getEm();
        $porpartida = $this->ObtenerVariable($request, 'porpartida');

        $editFormBuilder = $this->createFormBuilder()
            ->add('Actividad1', 'entity_id', array(
                'label' => 'Actividad principal',
                'required' => true,
                'class' => 'Yacare\ComercioBundle\Entity\Actividad',
                'required' => true))
            ->add('Actividad2', 'entity_id', array(
                'label' => 'Actividad adicional',
                'class' => 'Yacare\ComercioBundle\Entity\Actividad',
                'required' => true))
            ->add('Actividad3', 'entity_id', array(
                'label' => 'Actividad adicional',
                'class' => 'Yacare\ComercioBundle\Entity\Actividad',
                'required' => true))
            ->add('Actividad4', 'entity_id', array(
                'label' => 'Actividad adicional',
                'class' => 'Yacare\ComercioBundle\Entity\Actividad',
                'required' => true))
            ->add('Actividad5', 'entity_id', array(
                'label' => 'Actividad adicional',
                'class' => 'Yacare\ComercioBundle\Entity\Actividad',
                'required' => true))
            ->add('Actividad6', 'entity_id', array(
                'label' => 'Actividad adicional',
                'class' => 'Yacare\ComercioBundle\Entity\Actividad',
                'required' => true));
        if ($porpartida) {
            $editFormBuilder
                ->add('Partida', 'entity_id', array(
                    'label' => 'Partida',
                    'required' => true,
                    'class' => 'Yacare\CatastroBundle\Entity\Partida'))
                /* ->add('Tipo', new \Tapir\BaseBundle\Form\Type\ButtonGroupType(), array(
                    'label' => 'Tipo',
                    'data' => 'Local de ventas',
                    'required' => true,
                    'choices' => array(
                        'Local de ventas' => 'Local de ventas',
                        'Depósito' => 'Depósito',
                        'Otro' => 'Otro')))
                ->add('DepositoClase', 'entity', array(
                    'label' => 'Tipo de depósito',
                    'placeholder' => '(sólo para depósitos)',
                    'class' => 'Yacare\ComercioBundle\Entity\DepositoClase',
                    'required' => false)) */
                ->add('Superficie', new \Tapir\BaseBundle\Form\Type\SuperficieType(), array('label' => 'Superficie total'))
                ->add('SuperficieDeposito', new \Tapir\BaseBundle\Form\Type\SuperficieType(), array('label' => 'Depósito'))
                ;
        } else {
            $editFormBuilder
                ->add('Local', 'entity_id', array(
                    'label' => 'Local', 'class' => 'Yacare\ComercioBundle\Entity\Local'));
        }
        $editForm = $editFormBuilder->getForm();
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $data = $editForm->getData();

            if (array_key_exists('Local', $data)) {
                $Local = $data['Local'];
            } else {
                $Local = new \Yacare\ComercioBundle\Entity\Local();
                $Local->setSuperficie($data['Superficie']);
                $Local->setPartida($data['Partida']);
                //$Local->setTipo($data['Tipo']);
                $Local->setTipo("Local de ventas");
            }
            
            $Comercio = new \Yacare\ComercioBundle\Entity\Comercio();
            $Comercio->setLocal($Local);
            $Comercio->setActividad1($data['Actividad1']);
            $Comercio->setActividad2($data['Actividad2']);
            $Comercio->setActividad3($data['Actividad3']);
            $Comercio->setActividad4($data['Actividad4']);
            $Comercio->setActividad5($data['Actividad5']);
            $Comercio->setActividad6($data['Actividad6']);

            $THelper = new \Yacare\TramitesBundle\Helper\TramiteHelper($em);
            $ThcHelper = new \Yacare\ComercioBundle\Helper\TramiteHabilitacionComercialHelper($em);
            
            $UsosSuelo = $em->createQuery('SELECT u FROM Yacare\CatastroBundle\Entity\UsoSuelo u WHERE u.SuperficieMaxima=0')
                                ->getResult();
            
            $Tramite = new \Yacare\ComercioBundle\Entity\TramiteHabilitacionComercial();
            $Tramite->setComercio($Comercio);
            
            $THelper->PreUpdatePersist($Tramite);
            $ThcHelper->PreUpdatePersist($Tramite);

            return $this->ArrastrarVariables($request, array(
                'usossuelo' => $UsosSuelo,
                'porpartida' => $porpartida,
                'comercio' => $Comercio,
                'tramite' => $Tramite,
                'create' => 0,
                'errors' => '',
                'edit_form' => $editForm->createView()));
        }

        return $this->ArrastrarVariables($request, array(
            'entity' => null,
            'create' => true,
            'porpartida' => $porpartida,
            'errors' => '',
            'edit_form' => $editForm->createView()));
    }
}

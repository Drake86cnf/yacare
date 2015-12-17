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
    use \Tapir\AbmBundle\Controller\ConVer;
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
            ->add('Actividad1', 'Tapir\FormBundle\Form\Type\EntityIdType', array(
                'label' => 'Actividad principal',
                'required' => true,
                'class' => 'Yacare\ComercioBundle\Entity\Actividad',
                'required' => true))
            ->add('Actividad2', 'Tapir\FormBundle\Form\Type\EntityIdType', array(
                'label' => 'Actividad adicional',
                'class' => 'Yacare\ComercioBundle\Entity\Actividad',
                'required' => true))
            ->add('Actividad3', 'Tapir\FormBundle\Form\Type\EntityIdType', array(
                'label' => 'Actividad adicional',
                'class' => 'Yacare\ComercioBundle\Entity\Actividad',
                'required' => true))
            ->add('Actividad4', 'Tapir\FormBundle\Form\Type\EntityIdType', array(
                'label' => 'Actividad adicional',
                'class' => 'Yacare\ComercioBundle\Entity\Actividad',
                'required' => true))
            ->add('Actividad5', 'Tapir\FormBundle\Form\Type\EntityIdType', array(
                'label' => 'Actividad adicional',
                'class' => 'Yacare\ComercioBundle\Entity\Actividad',
                'required' => true))
            ->add('Actividad6', 'Tapir\FormBundle\Form\Type\EntityIdType', array(
                'label' => 'Actividad adicional',
                'class' => 'Yacare\ComercioBundle\Entity\Actividad',
                'required' => true));
        if ($porpartida) {
            $editFormBuilder
                ->add('Partida', 'Tapir\FormBundle\Form\Type\EntityIdType', array(
                    'label' => 'Partida',
                    'required' => true,
                    'class' => 'Yacare\CatastroBundle\Entity\Partida'))
                /* ->add('Tipo', 'Tapir\BaseBundle\Form\Type\ButtonGroupType', array(
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
                ->add('Superficie', 'Tapir\BaseBundle\Form\Type\SuperficieType', array('label' => 'Superficie total'))
                ->add('SuperficieDeposito', 'Tapir\BaseBundle\Form\Type\SuperficieType', array('label' => 'Depósito'))
                ;
        } else {
            $editFormBuilder
                ->add('Local', 'Tapir\FormBundle\Form\Type\EntityIdType', array(
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
                $Local->setTipo("Local comercial");
            }
            
            $Comercio = new \Yacare\ComercioBundle\Entity\Comercio();
            $Comercio->setLocal($Local);
            $Comercio->setActividad1($data['Actividad1']);
            $Comercio->setActividad2($data['Actividad2']);
            $Comercio->setActividad3($data['Actividad3']);
            $Comercio->setActividad4($data['Actividad4']);
            $Comercio->setActividad5($data['Actividad5']);
            $Comercio->setActividad6($data['Actividad6']);

            $THelper = new \Yacare\TramitesBundle\Helper\TramiteHelper(null, $em);
            $ThcHelper = new \Yacare\ComercioBundle\Helper\TramiteHabilitacionComercialHelper(null, $em);
            
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
    
    /**
     * @Route("asistente/")
     * @Template()
     */
    public function asistenteAction(Request $request) {
        $em = $this->getEm();
        
        $Sesion = $request->getSession();
        $Asistente = new \Yacare\ComercioBundle\Helper\Asistentes\NuevoTramiteHabilitacionComercial();

        $NombrePasoActual = $this->ObtenerVariable($request, 'paso');
        if(!$NombrePasoActual) {
            $NombrePasoActual = $Asistente->first()->getName();
            $EstadoActual = $Sesion->set('Asistente_NuevoTramiteHabilitacionComercial', null);
        } else {
            if($NombrePasoActual == 'fin') {
                $NombrePasoActual = $Asistente->last()->getName();
            } elseif($NombrePasoActual == 'inicio') {
                $NombrePasoActual = $Asistente->first()->getName();
            }
        }
        $PasoActual = $Asistente->get($NombrePasoActual);
        
        $a = '';
        $EstadoActual = $Sesion->get('Asistente_NuevoTramiteHabilitacionComercial', null);
        if($EstadoActual) {
            $serializer = $this->container->get('jms_serializer');
            $Tramite = $serializer->deserialize($EstadoActual, 'Yacare\ComercioBundle\Entity\TramiteHabilitacionComercial', 'json');
            //$Titular = $serializer->deserialize($Sesion->get('Asistente_NuevoTramite_Titular', null), 'Yacare\BaseBundle\Entity\Persona', 'json');
            $Titular = $Tramite->getTitular();
            
            //echo ''. $serializer->serialize($Tramite, 'json'); 
            if(!$Titular) {
                $Titular = new \Yacare\BaseBundle\Entity\Persona();
                $Titular->setNombre('(busque un contribuyente existente o deje en blanco para cargar uno nuevo)');
            } else {
                $em->merge($Titular);
                if($Titular->getGrupos()) {
                    foreach($Titular->getGrupos() as $Grupo) {
                        //echo $serializer->serialize($Grupo, 'json');
                        $em->merge($Grupo);
                    }
                }
            }
            
            $Tramite->setTitular($Titular);
            
            $Comercio = $Tramite->getComercio();
            $Local = $Comercio->getLocal();
        } else {
            // Parece que recién entro en el asistente
            $Comercio = new \Yacare\ComercioBundle\Entity\Comercio();
            $Comercio->setNombre('Comercio de prueba');
            
            $Titular = new \Yacare\BaseBundle\Entity\Persona();
            $Titular->setNombre('(busque un contribuyente existente o deje en blanco para cargar uno nuevo)');
            
            $Local = new \Yacare\ComercioBundle\Entity\Local();
            $Local->setNombre('(busque un local existente o deje en blanco para cargar uno nuevo)');
            
            $THelper = new \Yacare\TramitesBundle\Helper\TramiteHelper($em);
            $ThcHelper = new \Yacare\ComercioBundle\Helper\TramiteHabilitacionComercialHelper($em);
            
            $Tramite = new \Yacare\ComercioBundle\Entity\TramiteHabilitacionComercial();
            $Tramite->setComercio($Comercio);
            //$Tramite->getComercio()->setTitular($Titular);
            $Tramite->getComercio()->setLocal($Local);
            $Tramite->setTitular($Titular);
            
            $THelper->PreUpdatePersist($Tramite);
            $ThcHelper->PreUpdatePersist($Tramite);
            $a .= 'new';
        }
       

        $NombreDesdePaso = $this->ObtenerVariable($request, 'desdepaso');
        if($NombreDesdePaso) {
            //$a .= '--settit' . serialize($Tramite->getTitular());
            $DesdePaso = $Asistente->get($NombreDesdePaso);
            $FormEditarAnterior = $this->createForm($DesdePaso->getFormType(), $Tramite);
            $FormEditarAnterior->handleRequest($request);
            $serializer = $this->container->get('jms_serializer');
            
            $Titular = $Tramite->getTitular();
            //$em->detach($Tramite);
            if($Titular && $Titular->getId()) {
                //$em->detach($Titular);
            }
            $Sesion->set('Asistente_NuevoTramiteHabilitacionComercial', $serializer->serialize($Tramite, 'json'));
            $Sesion->set('Asistente_NuevoTramite_Titular', $serializer->serialize($Titular, 'json'));
            //$Sesion->set('Asistente_NuevoTramite_Titular', serialize($Tramite->getTitular()));
            //$a .= '--settit' . serialize($Tramite->getTitular());
        } 
        
        if(isset($DesdePaso) && $DesdePaso == $PasoActual) {
            $a .= '--fin!';
        }

        $FormEditar = $this->createForm($PasoActual->getFormType(), $Tramite);
        //$FormEditar->handleRequest($request);
        
        if ($FormEditar->isValid()) {
            // Si es el último paso, guardar
            //$em->detach($Tramite->getTitular());
            //$Sesion->set('Asistente_NuevoTramiteHabilitacionComercial_Titular', serialize($Tramite->getTitular()));
            //$em->detach($Tramite);
            //$Sesion->set('Asistente_NuevoTramiteHabilitacionComercial', serialize($Tramite));
            $a .= '--fet';
        } else {
            $validator = $this->get('validator');
            $Errores = $validator->validate($Tramite);
            foreach($Errores as $Error) {
                $a .= 'err:' . $Error;
            }
        }
        
        $res = $this->ConstruirResultado(new \Tapir\AbmBundle\Helper\Resultados\ResultadoAsistenteAction($this),
            $request);
        $res->Entidad = $Tramite;
        $res->FormularioEditar = $FormEditar->createView();
        $res->Asistente = $Asistente;
        $res->Paso = $PasoActual;
        
        //$a .= ' --- tra:' . $Sesion->get('Asistente_NuevoTramiteHabilitacionComercial', '');
        //$a .= ' --- tit:' . $Sesion->get('Asistente_NuevoTramite_Titular', '');
        //$a .= ' --- com:' . $Sesion->get('Asistente_NuevoTramiteHabilitacionComercial_Comercio', '');
               
        return array('res' => $res, 'a' => $a);
    }
}

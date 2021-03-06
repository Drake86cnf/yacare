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

    function IniciarVariables()
    {
        parent::IniciarVariables();
        
        $this->OrderBy = 'createdAt DESC';
    }

    /**
     * @Route("listar/")
     * @Template()
     */
    public function listarAction(Request $request)
    {
        $filtro_buscar = $this->ObtenerVariable($request, 'filtro_buscar');
        $filtro_estado = $this->ObtenerVariable($request, 'filtro_estado');
        
        if ($filtro_estado) {
            if ($filtro_estado == - 1) {
                // El -1 tiene el valor especial de Estado=0
                $this->Where .= " AND r.Estado=0";
            } else {
                $this->Where .= " AND r.Estado=$filtro_estado";
            }
        }
        if ($filtro_buscar) {
            $this->Joins[] = " LEFT JOIN r.Titular t";
            $this->Joins[] = " LEFT JOIN r.Comercio c";
            $this->Joins[] = " LEFT JOIN c.Local l";
            
            $this->BuscarPor = 'c.Nombre, c.ExpedienteNumero, l.Nombre, t.NombreVisible, t.RazonSocial, t.DocumentoNumero, t.Cuilt';
        }
        
        $ResultadoListar = parent::listarAction($request);
        $res = $ResultadoListar['res'];
        
        $res->Estados = \Yacare\TramitesBundle\Entity\Tramite::NombresEstados();
        
        return $ResultadoListar;
    }

    /**
     * @Route("consultar")
     * @Template()
     */
    public function consultarAction(Request $request)
    {
        $em = $this->getEm();
        $PorPartida = $this->ObtenerVariable($request, 'porpartida');
        
        $FormularioEditarBuilder = $this->createFormBuilder()
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

        $res = $this->ConstruirResultado(new \Tapir\AbmBundle\Helper\Resultados\ResultadoEditarGuardarAction($this), $request);

        if ($PorPartida) {
            $FormularioEditarBuilder
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
                ->add('SuperficieDeposito', 'Tapir\BaseBundle\Form\Type\SuperficieType', array('label' => 'Depósito'));
        } else {
            $FormularioEditarBuilder
                ->add('Local', 'Tapir\FormBundle\Form\Type\EntityIdType', array(
                    'label' => 'Local', 
                    'class' => 'Yacare\ComercioBundle\Entity\Local'));
        }
        
        $FormularioEditar = $FormularioEditarBuilder->getForm();
        $FormularioEditar->handleRequest($request);
        
        if ($FormularioEditar->isValid()) {
            $DatosFormulario = $FormularioEditar->getData();

            if (array_key_exists('Local', $DatosFormulario)) {
                $Local = $DatosFormulario['Local'];
            } else {
                $Local = new \Yacare\ComercioBundle\Entity\Local();
                $Local->setSuperficie($DatosFormulario['Superficie']);
                $Local->setPartida($DatosFormulario['Partida']);
                // $Local->setTipo($data['Tipo']);
                $Local->setTipo("Local comercial");
            }
            
            $Comercio = new \Yacare\ComercioBundle\Entity\Comercio();
            $Comercio->setLocal($Local);
            $Comercio->setActividad1($DatosFormulario['Actividad1']);
            $Comercio->setActividad2($DatosFormulario['Actividad2']);
            $Comercio->setActividad3($DatosFormulario['Actividad3']);
            $Comercio->setActividad4($DatosFormulario['Actividad4']);
            $Comercio->setActividad5($DatosFormulario['Actividad5']);
            $Comercio->setActividad6($DatosFormulario['Actividad6']);
            
            $THelper = new \Yacare\TramitesBundle\Helper\TramiteHelper($this->container, $em);
            $ThcHelper = new \Yacare\ComercioBundle\Helper\TramiteHabilitacionComercialHelper($this->container, $em);
            
            $UsosSuelo = $em->createQuery(
                'SELECT u FROM Yacare\CatastroBundle\Entity\UsoSuelo u WHERE u.SuperficieMaxima=0')->getResult();
            
            $Tramite = new \Yacare\ComercioBundle\Entity\TramiteHabilitacionComercial();
            $Tramite->setComercio($Comercio);
            
            $THelper->PreUpdatePersist($Tramite);
            $ThcHelper->PreUpdatePersist($Tramite);
            
            $res->UsoSuelo = $UsosSuelo;
            $res->Entidad = $Comercio;
            $res->Tramite = $Tramite;
        } else {
            $res->UsoSuelo = null;
            $res->Entidad = null;
            $res->Tramite = null;
        }        
        $res->PorPartida = $PorPartida;
        $res->FormularioEditar = $FormularioEditar->createView();
        
        return array('res' => $res);
    }

    /**
     * @Route("asistente/")
     * @Template()
     */
    public function asistenteAction(Request $request)
    {
        $em = $this->getEm();
        
        $Sesion = $request->getSession();
        $Asistente = new \Yacare\ComercioBundle\Helper\Asistentes\NuevoTramiteHabilitacionComercial();
        
        $NombrePasoActual = $this->ObtenerVariable($request, 'paso');
        if (! $NombrePasoActual) {
            $NombrePasoActual = $Asistente->first()->getName();
            $EstadoActual = $Sesion->set('Asistente_NuevoTramiteHabilitacionComercial', null);
        } else {
            if ($NombrePasoActual == 'fin') {
                $NombrePasoActual = $Asistente->last()->getName();
            } elseif ($NombrePasoActual == 'inicio') {
                $NombrePasoActual = $Asistente->first()->getName();
            }
        }
        $PasoActual = $Asistente->get($NombrePasoActual);
        
        $a = '';
        $EstadoActual = $Sesion->get('Asistente_NuevoTramiteHabilitacionComercial', null);
        
        if ($EstadoActual) {
            $serializer = $this->container->get('jms_serializer');
            $Tramite = $serializer->deserialize($EstadoActual, 
                'Yacare\ComercioBundle\Entity\TramiteHabilitacionComercial', 'json');
            // $Titular = $serializer->deserialize($Sesion->get('Asistente_NuevoTramite_Titular', null),
            // 'Yacare\BaseBundle\Entity\Persona', 'json');
            $Titular = $Tramite->getTitular();
            
            // echo ''. $serializer->serialize($Tramite, 'json');
            
            if (! $Titular) {
                $Titular = new \Yacare\BaseBundle\Entity\Persona();
                $Titular->setNombre('(busque un contribuyente existente o deje en blanco para cargar uno nuevo)');
            } else {
                $em->merge($Titular);
                if ($Titular->getGrupos()) {
                    foreach ($Titular->getGrupos() as $Grupo) {
                        // echo $serializer->serialize($Grupo, 'json');
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
            
            $THelper = new \Yacare\TramitesBundle\Helper\TramiteHelper($this->container, $em);
            $ThcHelper = new \Yacare\ComercioBundle\Helper\TramiteHabilitacionComercialHelper($this->container, $em);
            
            $Tramite = new \Yacare\ComercioBundle\Entity\TramiteHabilitacionComercial();
            $Tramite->setComercio($Comercio);
            // $Tramite->getComercio()->setTitular($Titular);
            $Tramite->getComercio()->setLocal($Local);
            $Tramite->setTitular($Titular);
            
            $THelper->PreUpdatePersist($Tramite);
            $ThcHelper->PreUpdatePersist($Tramite);
            $a .= 'new';
        }        
        $NombreDesdePaso = $this->ObtenerVariable($request, 'desdepaso');
        
        if ($NombreDesdePaso) {
            // $a .= '--settit' . serialize($Tramite->getTitular());
            $DesdePaso = $Asistente->get($NombreDesdePaso);
            $FormEditarAnterior = $this->createForm($DesdePaso->getFormType(), $Tramite);
            $FormEditarAnterior->handleRequest($request);
            $serializer = $this->container->get('jms_serializer');
            
            $Titular = $Tramite->getTitular();
            // $em->detach($Tramite);
            if ($Titular && $Titular->getId()) {
                // $em->detach($Titular);
            }
            $Sesion->set('Asistente_NuevoTramiteHabilitacionComercial', $serializer->serialize($Tramite, 'json'));
            $Sesion->set('Asistente_NuevoTramite_Titular', $serializer->serialize($Titular, 'json'));
            // $Sesion->set('Asistente_NuevoTramite_Titular', serialize($Tramite->getTitular()));
            // $a .= '--settit' . serialize($Tramite->getTitular());
        }
        
        if (isset($DesdePaso) && $DesdePaso == $PasoActual) {
            $a .= '--fin!';
        }
        $FormEditar = $this->createForm($PasoActual->getFormType(), $Tramite);
        // $FormEditar->handleRequest($request);
        
        if ($FormEditar->isValid()) {
            // Si es el último paso, guardar
            // $em->detach($Tramite->getTitular());
            // $Sesion->set('Asistente_NuevoTramiteHabilitacionComercial_Titular', serialize($Tramite->getTitular()));
            // $em->detach($Tramite);
            // $Sesion->set('Asistente_NuevoTramiteHabilitacionComercial', serialize($Tramite));
            $a .= '--fet';
        } else {
            $validator = $this->get('validator');
            $Errores = $validator->validate($Tramite);
            
            foreach ($Errores as $Error) {
                $a .= 'err:' . $Error;
            }
        }
        $res = $this->ConstruirResultado(new \Tapir\AbmBundle\Helper\Resultados\ResultadoAsistenteAction($this), 
            $request);
        $res->Entidad = $Tramite;
        $res->FormularioEditar = $FormEditar->createView();
        $res->Asistente = $Asistente;
        $res->Paso = $PasoActual;
        
        // $a .= ' --- tra:' . $Sesion->get('Asistente_NuevoTramiteHabilitacionComercial', '');
        // $a .= ' --- tit:' . $Sesion->get('Asistente_NuevoTramite_Titular', '');
        // $a .= ' --- com:' . $Sesion->get('Asistente_NuevoTramiteHabilitacionComercial_Comercio', '');
        
        return array('res' => $res, 'a' => $a);
    }
}

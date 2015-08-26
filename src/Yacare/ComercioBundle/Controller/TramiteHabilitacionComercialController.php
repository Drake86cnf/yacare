<?php
namespace Yacare\ComercioBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("tramitehabilitacioncomercial/")
 */
class TramiteHabilitacionComercialController extends \Yacare\TramitesBundle\Controller\TramiteController
{

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
        $porpartida = $this->ObtenerVariable($request, 'porpartida');
        
        $editFormBuilder = $this->createFormBuilder()
            ->add('Actividad1', 'entity_id', 
                array(
                    'label' => 'Actividad principal', 
                    'class' => 'Yacare\ComercioBundle\Entity\Actividad', 
                    'required' => true));
        if ($porpartida) {
            $editFormBuilder
                ->add('Partida', 'entity_id', 
                    array('label' => 'Partida', 'class' => 'Yacare\CatastroBundle\Entity\Partida'))
                ->add('Tipo', 'choice', 
                    array(
                        'label' => 'Tipo', 
                        'required' => true, 
                        'choices' => array(
                            'Local de ventas' => 'Local de ventas', 
                            'Oficina' => 'Oficina', 
                            'Galpón' => 'Galpón', 
                            'Depósito' => 'Depósito', 
                            'Otro' => 'Otro')))
                ->add('DepositoClase', 'entity', 
                    array(
                        'label' => 'Tipo de depósito', 
                        'placeholder' => '(sólo para depósitos)', 
                        'class' => 'Yacare\ComercioBundle\Entity\DepositoClase', 
                        'required' => false))
                ->add('Superficie', null, array('label' => 'Superficie (m²)'));
        } else {
            $editFormBuilder
                ->add('Local', 'entity_id', 
                    array('label' => 'Local', 'class' => 'Yacare\ComercioBundle\Entity\Local'));
        }
        $editForm = $editFormBuilder->getForm();
        $editForm->handleRequest($request);
        
        if ($editForm->isValid()) {
            $data = $editForm->getData();
            $Actividad = $data['Actividad1'];
            
            if (array_key_exists('Local', $data)) {
                $Local = $data['Local'];
                $Superficie = $Local->getSuperficie();
                $Partida = $Local->getPartida();
                $Tipo = $Local->getTipo();
            } else {
                $Local = null;
                $Superficie = $data['Superficie'];
                $Partida = $data['Partida'];
                $Tipo = $data['Tipo'];
            }
            $em = $this->getEm();
            
            $ValorUsoSuelo = 0;
            $UsoSuelo = $em->createQuery(
                'SELECT u FROM Yacare\CatastroBundle\Entity\UsoSuelo u WHERE u.Codigo=:codigo 
                    AND u.SuperficieMaxima<:sup ORDER BY u.SuperficieMaxima DESC')
                ->setParameter('codigo', $Actividad->getCodigoCpu())
                ->setParameter('sup', $Superficie)
                ->setMaxResults(1)
                ->getResult();
            if ($UsoSuelo && count($UsoSuelo) > 0) {
                $UsoSuelo = $UsoSuelo[0];
            }
            
            $Zona = $Partida->getZona();
            if ($Zona && $UsoSuelo) {
                $ValorUsoSuelo = $UsoSuelo->getUsoZona($Zona->getId());
            } else {
                $ValorUsoSuelo = 0;
            }
            
            return $this->ArrastrarVariables(
                $request, 
                array(
                    'usosuelo' => $ValorUsoSuelo, 
                    'usosuelo_nombre' => \Yacare\CatastroBundle\Entity\UsoSuelo::UsoSueloNombre($ValorUsoSuelo), 
                    'actividad' => $Actividad, 
                    'porpartida' => $porpartida, 
                    'local' => $Local, 
                    'zona' => $Zona, 
                    'partida' => $Partida, 
                    'tipo' => $Tipo, 
                    'superficie' => $Superficie, 
                    'create' => 0, 
                    'errors' => '', 
                    'edit_form' => $editForm->createView()));
        }
        
        return $this->ArrastrarVariables(
            $request, 
            array(
                'entity' => null, 
                'create' => true, 
                'porpartida' => $porpartida, 
                'errors' => '', 
                'edit_form' => $editForm->createView()));
    }

    public function guardarActionPrePersist($entity, $editForm)
    {
        $em = $this->getEm();
        $res = parent::guardarActionPrePersist($entity, $editForm);
        
        $Comercio = $entity->getComercio();
        if ($Comercio) {
            if ($Comercio->getEstado() == 0) {
                $Comercio->setEstado(1); // Habilitación en trámite
            }
            // Le doy al comercio el mismo titular y apoderado que inician trámite
            $Comercio->setTitular($entity->getTitular());
            $Comercio->setApoderado($entity->getApoderado());
            
            // Reordeno las actividades ingresadas por formulario con espacios en blanco entre una y otra.
            \Yacare\ComercioBundle\Controller\ComercioController::ReordenarActividades($Comercio);
            $em->persist($Comercio);
        }
        
        // Obtengo el CPU correspondiente a la actividad, para la cantidad de m2 de este local
        $Local = $Comercio->getLocal();
        if ($Local) {
            // $Superficie = $Local->getSuperficie();
            $Actividad = $Comercio->getActividad1();
            
            // Busco el uso del suelo para esa zona
            $UsoSuelo = $em->createQuery(
                'SELECT u FROM Yacare\CatastroBundle\Entity\UsoSuelo u WHERE u.Codigo=:codigo 
                    AND u.SuperficieMaxima<:sup ORDER BY u.SuperficieMaxima DESC')
                ->setParameter('codigo', $Actividad->getCodigoCpu())
                ->setParameter('sup', $Local->getSuperficie())
                ->setMaxResults(1)
                ->getResult();
            // Si es un array tomo el primero
            if ($UsoSuelo && count($UsoSuelo) > 0) {
                $UsoSuelo = $UsoSuelo[0];
            }
            
            if ($UsoSuelo) {
                $Partida = $Local->getPartida();
                if ($Partida) {
                    $Zona = $Partida->getZona();
                    if ($Zona) {
                        $entity->setUsoSuelo($UsoSuelo->getUsoZona($Zona->getId()));
                    }
                }
            }
        }
        $entity->setNombre('Trámite de habilitación de ' . $Comercio->getNombre());
        
        return $res;
    }
}

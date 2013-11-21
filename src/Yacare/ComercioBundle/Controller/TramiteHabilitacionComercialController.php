<?php

namespace Yacare\ComercioBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("tramitehabilitacioncomercial/")
 */
class TramiteHabilitacionComercialController extends \Yacare\TramitesBundle\Controller\TramiteController
{
    public function EmitirComprobante($tramite) {
        // Al finalizar un trámite de habilitación comercial, se emite el certificado correspondiente
        $em = $this->getDoctrine()->getManager();
        
        $Certi = new \Yacare\ComercioBundle\Entity\CertificadoHabilitacionComercial();
        
        $ComprobanteTipo = $em->getRepository('YacareTramitesBundle:ComprobanteTipo')->findOneBy(array(
                'Clase' => '\\' . get_class($Certi)
            ));

        $Certi->setComprobanteTipo($ComprobanteTipo);

        $Certi->setNombreFantasia($tramite->getNombreFantasia());
        $Certi->setTitular($tramite->getTitular());
        $Certi->setLocal($tramite->getLocal());
        $Certi->setActividadPrincipal($tramite->getActividadPrincipal());
        $Certi->setActividadSecundaria($tramite->getActividadSecundaria());
        $Certi->setActividadTerciaria($tramite->getActividadTerciaria());
        
        // Fecha de vencimiento 5 años a partir de hoy
        $Venc = new \DateTime();
        $Certi->setVencimiento($Venc->add(new \DateInterval('P5Y')));
        
        return $Certi;
    }


    /**
     * @Route("consultar")
     * @Template()
     */
    function consultarAction() {
        $request = $this->getRequest();
        $porpartida = $request->query->get('porpartida');
        
        $editFormBuilder = $this->createFormBuilder()
            ->add('ActividadPrincipal', 'entity_id', array(
                'label' => 'Actividad principal',
                'class' => 'Yacare\ComercioBundle\Entity\Actividad',
                'required'  => true
                ));
        if($porpartida) {
            $editFormBuilder->add('Partida', 'entity_id', array(
                'label' => 'Partida',
                'class' => 'Yacare\CatastroBundle\Entity\Partida'
                ))
            ->add('Tipo', 'choice', array(
                'label' => 'Tipo',
                'required'  => true,
                'choices' => array(
                    'Local de ventas' => 'Local de ventas',
                    'Oficina' => 'Oficina',
                    'Galpón' => 'Galpón',
                    'Depósito' => 'Depósito',
                    'Otro' => 'Otro'
                    )
                ))
            ->add('Superficie', null, array(
                'label' => 'Superficie (m²)'
                ));
        } else {
            $editFormBuilder->add('Local', 'entity_id', array(
                'label' => 'Local',
                'class' => 'Yacare\ComercioBundle\Entity\Local'
                ));
        }
        $editForm = $editFormBuilder->getForm();

        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $data = $editForm->getData();
            
            $Actividad = $data['ActividadPrincipal'];
            
            if(array_key_exists('Local', $data)) {
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

            $em = $this->getDoctrine()->getManager();
            
            $ValorUsoSuelo = 0;
            $UsoSuelo = $em->createQuery('SELECT u FROM Yacare\CatastroBundle\Entity\UsoSuelo u WHERE u.Codigo=:codigo AND u.SuperficieMaxima<:sup ORDER BY u.SuperficieMaxima DESC')
                    ->setParameter('codigo', $Actividad->getCodigoCpu())
                    ->setParameter('sup', $Superficie)
                    ->setMaxResults(1)
                    ->getResult();
            if($UsoSuelo && count($UsoSuelo) > 0) {
                $UsoSuelo = $UsoSuelo[0];
            }
            
            $Zona = $Partida->getZona();
            if($Zona && $UsoSuelo) {
                $ValorUsoSuelo = $UsoSuelo->getUsoZona($Zona->getId());
            } else {
                $ValorUsoSuelo = 0;
            }
            
            return $this->ArrastrarVariables(array(
                'usosuelo'    => $ValorUsoSuelo,
                'usosuelo_nombre' => \Yacare\CatastroBundle\Entity\UsoSuelo::UsoSueloNombre($ValorUsoSuelo),
                'actividad'   => $Actividad,
                'porpartida'  => $porpartida,
                'local'       => $Local,
                'zona'        => $Zona,
                'partida'     => $Partida,
                'tipo'        => $Tipo,
                'superficie'  => $Superficie,
                'create'      => 0,
                'errors'      => '',
                'edit_form'   => $editForm->createView()
            ));
        }

        return $this->ArrastrarVariables(array(
            'entity'      => null,
            'create'      => true,
            'porpartida'  => $porpartida,
            'errors'      => '',
            'edit_form'   => $editForm->createView()
        ));
    }    
    
    public function guardarActionPrePersist($entity) {
        $res = parent::guardarActionPrePersist($entity);
        
        // Obtengo el CPU correspondiente a la actividad, para la cantidad de m2 de este local
        $Local = $entity->getLocal();
        if($Local) {
            $Superficie = $Local->getSuperficie();
            $Actividad = $entity->getActividadPrincipal();

            $em = $this->getDoctrine()->getManager();
            
            $ValorUsoSuelo = 0;
            $UsoSuelo = $em->createQuery('SELECT u FROM Yacare\CatastroBundle\Entity\UsoSuelo u WHERE u.Codigo=:codigo AND u.SuperficieMaxima<:sup ORDER BY u.SuperficieMaxima DESC')
                    ->setParameter('codigo', $Actividad->getCodigoCpu())
                    ->setParameter('sup', $Local->getSuperficie())
                    ->setMaxResults(1)
                    ->getResult();
            if($UsoSuelo && count($UsoSuelo) > 0)
                $UsoSuelo = $UsoSuelo[0];
            
            $Partida = $Local->getPartida();
            if($Partida) {
                $Zona = $Partida->getZona();
                if($Zona) {
                    $entity->setUsoSuelo($UsoSuelo->getUsoZona($Zona->getId()));
                }
            }
        }
        return $res;
    }

    
    /**
     * @Route("ver/{id}")
     * @Template()
     */
    function verAction($id = null) {
        return $this->editarAction($id);
    }
}

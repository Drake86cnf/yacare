<?php

namespace Yacare\BaseBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

trait ConAdjuntos {
    public function guardarActionSubirArchivos($entity, $editForm) {
        parent::guardarActionSubirArchivos($entity, $editForm);
        
        $Archivos = $editForm->get('Adjuntos')->getData();

        if ($Archivos && count($Archivos) > 0) {
            $NombresAdjuntados = null;
            foreach($Archivos as $Archivo) {
                if ($Archivo) {
                    $Adjunto = new \Yacare\BaseBundle\Entity\Adjunto($entity, $Archivo);
                    
                    $Adjunto->setPersona($this->get('security.context')->getToken()->getUser());

                    $entity->getAdjuntos()->add($Adjunto);
                    if ($NombresAdjuntados) {
                        $NombresAdjuntados .= ', "' . (string)$Adjunto . '"';
                    } else {
                        $NombresAdjuntados = '"' . (string)$Adjunto . '"';
                    }
                }
            }

            if (count($Archivos) == 1 && $NombresAdjuntados) {
                $this->get('session')->getFlashBag()->add('success', 'Se adjuntó el archivo ' . $NombresAdjuntados . '.');
            } elseif (count($Archivos) > 1) {
                $this->get('session')->getFlashBag()->add('success', 'Se adjuntaron los archivos ' . $NombresAdjuntados . '.');
            }
        }
    }
}
<?php

namespace Yacare\BaseBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

trait ConAdjuntos {
    public function guardarActionPrePersist($entity, $editForm) {
        parent::guardarActionPrePersist($entity, $editForm);
        
        $Archivos = $editForm->get('Adjuntos')->getData();

        if($Archivos) {
            $NombresAdjuntados = null;
            foreach($Archivos as $Archivo) {
                $Adjunto = new \Yacare\BaseBundle\Entity\Adjunto($entity, $Archivo);
                $entity->getAdjuntos()->add($Adjunto);
                if($NombresAdjuntados) {
                    $NombresAdjuntados .= ', "' . (string)$Adjunto . '"';
                } else {
                    $NombresAdjuntados = '"' . (string)$Adjunto . '"';
                }
            }

            if(count($Archivos) == 1) {
                $this->get('session')->getFlashBag()->add('success', 'Se adjuntó el archivo ' . $NombresAdjuntados . '.');
            } else if(count($Archivos) > 1) {
                $this->get('session')->getFlashBag()->add('success', 'Se adjuntaron los archivos ' . $NombresAdjuntados . '.');
            }
        }
    }
}
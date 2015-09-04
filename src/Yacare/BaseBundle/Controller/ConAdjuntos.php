<?php
namespace Yacare\BaseBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Agrega la capacidad de almacenar archivos adjuntos.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
trait ConAdjuntos
{
    public function guardarActionSubirArchivos($entity, $editForm)
    {
        parent::guardarActionSubirArchivos($entity, $editForm);
        
        $Archivos = $editForm->get('Adjuntos')->getData();
        print_r($Archivos);
        if (count($Archivos) == 1) {
            $Archivos = $Archivos[0];
        }
        
        if ($Archivos && count($Archivos) > 0) {
            $NombresAdjuntados = array();
            foreach ($Archivos as $Archivo) {
                if ($Archivo) {
                    $Adjunto = new \Yacare\BaseBundle\Entity\Adjunto($entity, $Archivo);
                    
                    $Adjunto->setPersona(
                        $this->get('security.token_storage')
                            ->getToken()
                            ->getUser());
                    
                    $entity->getAdjuntos()->add($Adjunto);
                    $NombresAdjuntados[] = '"' . (string) $Adjunto . '"';
                }
            }
            
            if (count($NombresAdjuntados) == 1) {
                $this->get('session')->getFlashBag()->add('success', 
                    'Se adjuntó el archivo ' . implode(',', $NombresAdjuntados) . '.');
            } elseif (count($NombresAdjuntados) > 1) {
                $this->get('session')->getFlashBag()->add('success', 
                    'Se adjuntaron los archivos ' . implode(',', $NombresAdjuntados) . '.');
            }
        }
    }
}

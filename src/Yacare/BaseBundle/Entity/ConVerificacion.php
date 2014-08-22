<?php

namespace Yacare\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Agrega la capacidad de que algo tenga una marca de nivel de verificación.
 * 
 * Por ejemplo para datos personales (como domicilio) sin verificar o verificados por distintos medios.
 */
trait ConVerificacion
{
    /**
     * @var integer
     * @ORM\Column(type="integer", nullable=false)
     */
    private $VerificacionNivel;
    
    static public function VerificacionNivelNombre($verificacionNivel) {
        switch($verificacionNivel) {
            case 1: return 'Sin verificar';
            case 2: return 'Validado';
            case 3: return 'Validado';
            default: return 'Desconocido';
        }
    }
    
    public function getVerificacionNivelNombre() {
        return Persona::VerificacionNivelNombre($this->getVerificacionNivel());
    }
}
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
     * @var integer @ORM\Column(type="integer", nullable=false)
     */
    private $VerificacionNivel = 0;

    public static function VerificacionNivelNombre($verificacionNivel)
    {
        switch ($verificacionNivel) {
            case 0:
                return 'Sin confirmar';
            case 10:
                return 'Confirmado';
            case 20:
                return 'Cotejado';
            case 30:
                return 'Certificado';
            case 40:
                return 'Nativo';
            default:
                return 'Desconocido';
        }
    }

    public function getVerificacionNivelNombre()
    {
        return Persona::VerificacionNivelNombre($this->getVerificacionNivel());
    }
}

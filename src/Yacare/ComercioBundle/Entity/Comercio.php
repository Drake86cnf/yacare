<?php
namespace Yacare\ComercioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * El comercio.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 *
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 * @ORM\Table(name="Comercio_Comercio")
 */
class Comercio implements IComercio
{
    use \Tapir\BaseBundle\Entity\ConId;
    use \Tapir\BaseBundle\Entity\ConNombre;
    use \Yacare\ComercioBundle\Entity\ConDatosComercio;
    use \Yacare\AdministracionBundle\Entity\ConExpediente;
    use \Yacare\AdministracionBundle\Entity\ConActoAdministrativo;
    use \Tapir\BaseBundle\Entity\Suprimible;
    use \Tapir\BaseBundle\Entity\Versionable;
    use \Yacare\TramitesBundle\Entity\ConTitular;
    use \Yacare\TramitesBundle\Entity\ConApoderado;
    
    /**
     * @var integer
     * 
     * @ORM\Column(type="integer")
     */
    protected $Estado = 0;
    
    /**
     * @var CertificadoHabilitacionComercial
     * 
     * @ORM\ManyToOne(targetEntity="Yacare\ComercioBundle\Entity\CertificadoHabilitacionComercial")
     * @ORM\JoinColumn(nullable=true)
     */
    protected $CertificadoHabilitacion;

    /**
     * Devuelve nombres de estado normalizados.
     * 
     * @param  integer $estado
     * @return string
     */
    public static function NombreEstado($estado)
    {
        switch ($estado) {
            case 0:
                return 'No habilitado';
            case 1:
                return 'En trámite';
            case 90:
                return 'Cerrado';
            case 91:
                return 'Hab. vencida';
            case 100:
                return 'Habilitado';
            default:
                return '???';
        }
    }

    /**
     * Obtiene el nombre de estado.
     * 
     * @return string
     */
    public function getEstadoNombre()
    {
        return self::NombreEstado($this->Estado);
    }

    public function DomicilioLegalAmbulante()
    {
        if ($this->getLocal()) {
            return false;
        }
    }

    /**
     * @ignore
     */
    public function getEstado()
    {
        return $this->Estado;
    }

    /**
     * @ignore
     */
    public function setEstado($Estado)
    {
        $this->Estado = $Estado;
    }

    public function getCertificadoHabilitacion()
    {
        return $this->CertificadoHabilitacion;
    }

    public function setCertificadoHabilitacion(CertificadoHabilitacionComercial $CertificadoHabilitacion)
    {
        $this->CertificadoHabilitacion = $CertificadoHabilitacion;
        return $this;
    }
}

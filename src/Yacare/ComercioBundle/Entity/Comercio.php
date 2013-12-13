<?php
namespace Yacare\ComercioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yacare\ComercioBundle\Entity\Comercio
 *
 * @ORM\Entity
 * @ORM\Table(name="Comercio_Comercio")
 */
class Comercio {
    use \Yacare\BaseBundle\Entity\ConId;
    use \Yacare\BaseBundle\Entity\ConNombre;

    use \Yacare\ComercioBundle\Entity\ConDatosComercio;
    
    use \Yacare\BaseBundle\Entity\Suprimible;
    use \Yacare\BaseBundle\Entity\Versionable;
    
    use \Yacare\TramitesBundle\Entity\ConTitular;
    use \Yacare\TramitesBundle\Entity\ConApoderado;
    
    /**
     * @ORM\Column(type="integer")
     */
    protected $Estado = 0;
    
    /**
     * @ORM\ManyToOne(targetEntity="Yacare\ComercioBundle\Entity\CertificadoHabilitacionComercial")
     * @ORM\JoinColumn(nullable=true)
     */
    protected $CertificadoHabilitacion;
    
    
    
    public static function NombreEstado($estado) {
        switch($estado) {
            case 0: return 'No habilitado';
            case 1: return 'En trámite';
            case 91: return 'Hab. vencida';
            case 100: return 'Habilitado';
            default: return '???';
        }
    }
    
    public function getEstadoNombre() {
        return Comercio::NombreEstado($this->Estado);
    }
    
    
    
    
    public function getEstado() {
        return $this->Estado;
    }

    public function setEstado($Estado) {
        $this->Estado = $Estado;
    }
    
    public function getCertificadoHabilitacion() {
        return $this->CertificadoHabilitacion;
    }

    public function setCertificadoHabilitacion($CertificadoHabilitacion) {
        $this->CertificadoHabilitacion = $CertificadoHabilitacion;
    }
}

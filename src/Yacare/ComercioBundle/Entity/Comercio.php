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
    
    
    public function __toString() {
        return $this->getNombreFantasia();
    }
    
    public static function NombreEstado($estado) {
        switch($estado) {
            case 0: return 'En trámite';
            case 100: return 'Habilitado';
            default: return '???';
        }
    }
    
    public function getEstadoNombre() {
        return EstadoRequisito::NombreEstado($this->Estado);
    }
    
    
    
    
    public function getEstado() {
        return $this->Estado;
    }

    public function setEstado($Estado) {
        $this->Estado = $Estado;
    }
}

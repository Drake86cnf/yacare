<?php

namespace Yacare\ObrasParticularesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yacare\ObrasParticularesBundle\Entity\InspeccionComercio
 *
 * @ORM\Table(name="ObrasParticulares_InspeccionComercio")
 * @ORM\Entity(repositoryClass="Yacare\BaseBundle\Entity\YacareBaseRepository")
 */
class InspeccionComercio
{
    use \Yacare\BaseBundle\Entity\ConId;
    use \Yacare\BaseBundle\Entity\ConObs;
    use \Yacare\CatastroBundle\Entity\ConPartida;
    use \Yacare\ComercioBundle\Entity\ConActividades;
    use \Yacare\ExpedientesBundle\Entity\ConExpediente;
    use \Yacare\TramitesBundle\Entity\ConTitular;
    use \Yacare\BaseBundle\Entity\Versionable;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
    
    /**
     * @ORM\Column(type="decimal", precision=14, scale=2, nullable=true)
     */
    private $Superficie;
    
    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $NumeroSolicitud;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $TitularNombre;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $ActividadNombre;
    
    
    public function __toString() {
        return 'Inspección Nº ' . $this->getId();
    }
    
    
    public function getSuperficie() {
        return $this->Superficie;
    }

    public function setSuperficie($Superficie) {
        $this->Superficie = $Superficie;
    }
    
    public function getNumeroSolicitud() {
        return $this->NumeroSolicitud;
    }

    public function setNumeroSolicitud($NumeroSolicitud) {
        $this->NumeroSolicitud = $NumeroSolicitud;
    }
    
    public function getTitularNombre() {
        return $this->TitularNombre;
    }

    public function setTitularNombre($TitularNombre) {
        $this->TitularNombre = $TitularNombre;
    }

    public function getActividadNombre() {
        return $this->ActividadNombre;
    }

    public function setActividadNombre($ActividadNombre) {
        $this->ActividadNombre = $ActividadNombre;
    }
}

<?php

namespace Yacare\InspeccionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\DBAL\Types;

/**
 * Yacare\InspeccionBundle\Entity\RelevamientoAsignacionResultado
 *
 * @ORM\Table(name="Inspeccion_RelevamientoAsignacionResultado")
 * @ORM\Entity
 */
class RelevamientoAsignacionResultado
{
    use \Yacare\BaseBundle\Entity\ConId;
    use \Yacare\BaseBundle\Entity\Timestampable;
    use \Yacare\BaseBundle\Entity\Versionable;
    use \Yacare\BaseBundle\Entity\ConImagen;
    use \Yacare\BaseBundle\Entity\Eliminable;

    /**
     * @ORM\ManyToOne(targetEntity="RelevamientoResultado")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    protected $Resultado;
    
    /**
     * @ORM\ManyToOne(targetEntity="RelevamientoAsignacion")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    protected $Asignacion;
    
    /**
     * @ORM\ManyToOne(targetEntity="RelevamientoAsignacionDetalle")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    protected $Detalle;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    protected $Obs;
    
    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $Ubicacion;



    public function getUbicacionLatitud() {
        if($this->Ubicacion){
            $x = sscanf($this->Ubicacion, "POINT(%f %f)");
            $Latitud = $x[0];
        } else {
            $Latitud = null;
        }
        return $Latitud;
    }

    
    public function getUbicacionLongitud() {
        if($this->Ubicacion){
            $x = sscanf($this->Ubicacion, "POINT(%f %f)");
            $Longitud = $x[1];
        } else {
            $Longitud = null;
        }
        return $Longitud;
    }

    
    public function getResultado() {
        return $this->Resultado;
    }

    public function setResultado($Resultado) {
        $this->Resultado = $Resultado;
    }

    public function getDetalle() {
        return $this->Detalle;
    }

    public function setDetalle($Detalle) {
        $this->Detalle = $Detalle;
    }
    
    public function getObs() {
        return $this->Obs;
    }

    public function setObs($Obs) {
        $this->Obs = $Obs;
    }

    public function getUbicacion() {
        return $this->Ubicacion;
    }

    public function setUbicacion($Ubicacion) {
        $this->Ubicacion = $Ubicacion;
    }
}

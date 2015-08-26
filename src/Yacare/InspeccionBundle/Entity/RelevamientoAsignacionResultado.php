<?php
namespace Yacare\InspeccionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\DBAL\Types;

/**
 * Resultado de una asignación.
 *
 * @see RelevamientoAsignacion
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 *        
 * @ORM\Table(name="Inspeccion_RelevamientoAsignacionResultado")
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 */
class RelevamientoAsignacionResultado
{
    use \Tapir\BaseBundle\Entity\ConId;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
    use \Tapir\BaseBundle\Entity\Versionable;
    use \Tapir\BaseBundle\Entity\ConImagen;
    use \Tapir\BaseBundle\Entity\Suprimible;
    
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
     * 
     * @ORM\Column(type="text", nullable=true)
     */
    protected $Obs;
    
    /**
     * @var string 
     * 
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $Ubicacion;

    public function getUbicacionLatitud()
    {
        if ($this->Ubicacion) {
            $x = sscanf($this->Ubicacion, "POINT(%f %f)");
            $Latitud = $x[0];
        } else {
            $Latitud = null;
        }
        return $Latitud;
    }
    
    public function getUbicacionLongitud()
    {
        if ($this->Ubicacion) {
            $x = sscanf($this->Ubicacion, "POINT(%f %f)");
            $Longitud = $x[1];
        } else {
            $Longitud = null;
        }
        return $Longitud;
    }
    
    /**
     * @ignore
     */
    public function getRelevamiento()
    {
        return $this->getAsignacion()->getRelevamiento();
    }

    /**
     * @ignore
     */
    public function getResultado()
    {
        return $this->Resultado;
    }
    
    /**
     * @ignore
     */
    public function setResultado($Resultado)
    {
        $this->Resultado = $Resultado;
    }

    /**
     * @ignore
     */
    public function getDetalle()
    {
        return $this->Detalle;
    }

    /**
     * @ignore
     */
    public function setDetalle($Detalle)
    {
        $this->Detalle = $Detalle;
    }

    /**
     * @ignore
     */
    public function getObs()
    {
        return $this->Obs;
    }

    /**
     * @ignore
     */
    public function setObs($Obs)
    {
        $this->Obs = $Obs;
    }

    /**
     * @ignore
     */
    public function getUbicacion()
    {
        return $this->Ubicacion;
    }

    /**
     * @ignore
     */
    public function setUbicacion($Ubicacion)
    {
        $this->Ubicacion = $Ubicacion;
    }
}

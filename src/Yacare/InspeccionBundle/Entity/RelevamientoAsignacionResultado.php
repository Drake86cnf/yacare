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
    /*
    
    INSERT INTO Inspeccion_RelevamientoAsignacionResultado
	(Detalle_id, Relevamiento_id, Asignacion_id, Encargado_id, Partida_id,
		Resultado_id, PartidaSeccion, PartidaMacizo, PartidaParcela, PartidaCalleNombre,
		PartidaCalleNumero, Obs, Ubicacion, Imagen, CreatedAt, UpdatedAt, Version)
SELECT id, Relevamiento_id, Asignacion_id, Encargado_id, Partida_id,
		Resultado1_id, PartidaSeccion, PartidaMacizo, PartidaParcela, PartidaCalleNombre,
		PartidaCalleNumero, ResultadoObs, ResultadoUbicacion, Imagen, UpdatedAt, UpdatedAt, 1
		FROM Inspeccion_RelevamientoAsignacionDetalle
		WHERE Resultado1_id IS NOT NULL;
     */
    use \Yacare\BaseBundle\Entity\Timestampable;
    use \Yacare\BaseBundle\Entity\Versionable;
    use \Yacare\BaseBundle\Entity\ConImagen;
    use \Yacare\BaseBundle\Entity\Eliminable;

    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * 
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="RelevamientoResultado")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    protected $Resultado;
    
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
    
    /**
     * Get id
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
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

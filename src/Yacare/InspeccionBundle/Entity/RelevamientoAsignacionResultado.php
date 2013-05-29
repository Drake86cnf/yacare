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
     * @ORM\ManyToOne(targetEntity="Relevamiento")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    protected $Relevamiento;
    
    /**
     * @ORM\ManyToOne(targetEntity="RelevamientoAsignacion", cascade={"remove"})
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    protected $Asignacion;
    
    /**
     * @ORM\ManyToOne(targetEntity="Yacare\BaseBundle\Entity\Persona")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    protected $Encargado;
    
    /**
     * @ORM\ManyToOne(targetEntity="Yacare\CatastroBundle\Entity\Partida")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    protected $Partida;
    
    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $PartidaSeccion;
    
    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $PartidaMacizo;
    
    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $PartidaParcela;
    
    /**
     * @ORM\ManyToOne(targetEntity="Yacare\CatastroBundle\Entity\Calle")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    protected $PartidaCalle;
    
    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $PartidaCalleNombre;
    
    /**
     * @var integer
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $PartidaCalleNumero;
    
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
    
    public function getRelevamiento() {
        return $this->Relevamiento;
    }

    public function setRelevamiento($Relevamiento) {
        $this->Relevamiento = $Relevamiento;
    }

    public function getAsignacion() {
        return $this->Asignacion;
    }

    public function setAsignacion($Asignacion) {
        $this->Asignacion = $Asignacion;
    }

    public function getEncargado() {
        return $this->Encargado;
    }

    public function setEncargado($Encargado) {
        $this->Encargado = $Encargado;
    }

    public function getPartida() {
        return $this->Partida;
    }

    public function setPartida($Partida) {
        $this->Partida = $Partida;
    }

    public function getPartidaSeccion() {
        return $this->PartidaSeccion;
    }

    public function setPartidaSeccion($PartidaSeccion) {
        $this->PartidaSeccion = $PartidaSeccion;
    }

    public function getPartidaMacizo() {
        return $this->PartidaMacizo;
    }

    public function setPartidaMacizo($PartidaMacizo) {
        $this->PartidaMacizo = $PartidaMacizo;
    }

    public function getPartidaParcela() {
        return $this->PartidaParcela;
    }

    public function setPartidaParcela($PartidaParcela) {
        $this->PartidaParcela = $PartidaParcela;
    }

    public function getPartidaCalle() {
        return $this->PartidaCalle;
    }

    public function setPartidaCalle($PartidaCalle) {
        $this->PartidaCalle = $PartidaCalle;
    }

    public function getPartidaCalleNombre() {
        return $this->PartidaCalleNombre;
    }

    public function setPartidaCalleNombre($PartidaCalleNombre) {
        $this->PartidaCalleNombre = $PartidaCalleNombre;
    }

    public function getPartidaCalleNumero() {
        return $this->PartidaCalleNumero;
    }

    public function setPartidaCalleNumero($PartidaCalleNumero) {
        $this->PartidaCalleNumero = $PartidaCalleNumero;
    }

    public function getResultadosCantidad() {
        return $this->ResultadosCantidad;
    }

    public function setResultadosCantidad($ResultadosCantidad) {
        $this->ResultadosCantidad = $ResultadosCantidad;
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

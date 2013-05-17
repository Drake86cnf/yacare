<?php

namespace Yacare\InspeccionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\DBAL\Types;

/**
 * Yacare\InspeccionBundle\Entity\RelevamientoAsignacionDetalle
 *
 * @ORM\Table(name="Inspeccion_RelevamientoAsignacionDetalle")
 * @ORM\Entity
 */
class RelevamientoAsignacionDetalle
{
    use \Yacare\BaseBundle\Entity\Timestampable;
    use \Yacare\BaseBundle\Entity\Versionable;

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
     * @ORM\ManyToOne(targetEntity="RelevamientoAsignacion")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    protected $Asignacion;
    
    /**
     * @ORM\ManyToOne(targetEntity="Yacare\RecursosHumanosBundle\Entity\Agente")
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
     * @var string
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $PartidaCalle;
    
    /**
     * @var integer
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $PartidaCalleNumero;
    
    /**
     * @ORM\ManyToOne(targetEntity="RelevamientoResultado")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    protected $Resultado1;
    
    /**
     * @ORM\ManyToOne(targetEntity="RelevamientoResultado")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    protected $Resultado2;
    
    /**
     * @ORM\ManyToOne(targetEntity="RelevamientoResultado")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    protected $Resultado3;
    
    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    protected $ResultadoObs;
    
    
    /**
     * @var string
     * @ORM\Column(type="blob", nullable=true)
     */
    protected $ResultadoImagen;
    
    
    /**
     * @var string
     * @ORM\Column(type="point", nullable=true)
     */
    protected $ResultadoUbicacion;
    
    
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

    public function getPartidaCalleNumero() {
        return $this->PartidaCalleNumero;
    }

    public function setPartidaCalleNumero($PartidaCalleNumero) {
        $this->PartidaCalleNumero = $PartidaCalleNumero;
    }
    
    public function getEncargado() {
        return $this->Encargado;
    }

    public function setEncargado($Encargado) {
        $this->Encargado = $Encargado;
    }

    public function getResultado1() {
        return $this->Resultado1;
    }

    public function setResultado1($Resultado1) {
        $this->Resultado1 = $Resultado1;
    }

    public function getResultado2() {
        return $this->Resultado2;
    }

    public function setResultado2($Resultado2) {
        $this->Resultado2 = $Resultado2;
    }

    public function getResultado3() {
        return $this->Resultado3;
    }

    public function setResultado3($Resultado3) {
        $this->Resultado3 = $Resultado3;
    }

    public function getResultadoObs() {
        return $this->ResultadoObs;
    }

    public function setResultadoObs($ResultadoObs) {
        $this->ResultadoObs = $ResultadoObs;
    }

    public function getResultadoImagen() {
        return $this->ResultadoImagen;
    }

    public function setResultadoImagen($ResultadoImagen) {
        $this->ResultadoImagen = $ResultadoImagen;
    }

    public function getResultadoUbicacion() {
        return $this->ResultadoUbicacion;
    }

    public function setResultadoUbicacion($ResultadoUbicacion) {
        $this->ResultadoUbicacion = $ResultadoUbicacion;
    }
}

<?php

namespace Yacare\CatastroBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yacare\CatastroBundle\Entity\Partida
 *
 * @ORM\Table(name="Catastro_Partida")
 * @ORM\Entity
 * 
 * UPDATE Catastro_Partida 
	SET Nombre=CONCAT('Sección ', Seccion, ', macizo ', MacizoAlfa, MacizoNum, ', parcela ', ParcelaAlfa, ParcelaNum);
 * UPDATE Catastro_Partida 
	SET DomicilioNumero=NULL WHERE DomicilioNumero=0;
 * 
 */
class Partida
{
    use \Yacare\BaseBundle\Entity\ConId;
    use \Yacare\BaseBundle\Entity\ConNombre;
    use \Yacare\BaseBundle\Entity\ConDomicilioLocal;
    use \Yacare\BaseBundle\Entity\Versionable;
    use \Yacare\BaseBundle\Entity\Importable;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;

    /**
     * @var string $Seccion
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $Seccion;
    
    /**
     * @var string $MacizoAlfa
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $MacizoAlfa;
    
    /**
     * @var string $MacizoNum
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $MacizoNum;
    
    /**
     * @var string $Macizo
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $Macizo;
    
    /**
     * @var string $ParcelaAlfa
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $ParcelaAlfa;
    
    /**
     * @var string $ParcelaNum
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $ParcelaNum;
    
    /**
     * @var string $Parcela
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $Parcela;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $UnidadFuncional;
    
    
    /**
     * @var string
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $Zonificacion;
    
    /**
     * @var
     * @ORM\Column(type="integer")
     */
    private $Numero;
    
    
    /**
     * @var
     * @ORM\Column(type="integer")
     */
    private $Legajo;
    
    
    public function getNombre() {
        $this->Nombre = "Sección " . $this->getSeccion() . ", macizo " . $this->getMacizoNum() . $this->getMacizoAlfa() . ", parcela " . $this->getParcelaNum() . $this->getParcelaAlfa();
        return $this->Nombre;
    }

    public function setNombre($Nombre) {
        $this->Nombre = "Sección " . $this->getSeccion() . ", macizo " . $this->getMacizoNum() . $this->getMacizoAlfa() . ", parcela " . $this->getParcelaNum() . $this->getParcelaAlfa();
    }

    public function getSeccion() {
        return $this->Seccion;
    }

    public function setSeccion($Seccion) {
        $this->Seccion = $Seccion;
    }

    public function getMacizoAlfa() {
        return $this->MacizoAlfa;
    }

    public function setMacizoAlfa($MacizoAlfa) {
        $this->MacizoAlfa = $MacizoAlfa;
    }

    public function getMacizoNum() {
        return $this->MacizoNum;
    }

    public function setMacizoNum($MacizoNum) {
        $this->MacizoNum = $MacizoNum;
    }

    public function getParcelaAlfa() {
        return $this->ParcelaAlfa;
    }

    public function setParcelaAlfa($ParcelaAlfa) {
        $this->ParcelaAlfa = $ParcelaAlfa;
    }

    public function getParcelaNum() {
        return $this->ParcelaNum;
    }

    public function setParcelaNum($ParcelaNum) {
        $this->ParcelaNum = $ParcelaNum;
    }

    public function getMacizo() {
        return $this->Macizo;
    }

    public function setMacizo($Macizo) {
        $this->Macizo = $Macizo;
    }

    public function getParcela() {
        return $this->Parcela;
    }

    public function setParcela($Parcela) {
        $this->Parcela = $Parcela;
    }
    
    public function getZonificacion() {
        return $this->Zonificacion;
    }

    public function setZonificacion($Zonificacion) {
        $this->Zonificacion = $Zonificacion;
    }
    
    public function getUnidadFuncional() {
        return $this->UnidadFuncional;
    }

    public function getLegajo() {
        return $this->Legajo;
    }

    public function setUnidadFuncional($UnidadFuncional) {
        $this->UnidadFuncional = $UnidadFuncional;
    }

    public function setLegajo($Legajo) {
        $this->Legajo = $Legajo;
    }
    
    public function getNumero() {
        return $this->Numero;
    }

    public function setNumero($Numero) {
        $this->Numero = $Numero;
    }
}

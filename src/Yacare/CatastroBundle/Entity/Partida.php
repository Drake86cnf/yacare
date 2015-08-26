<?php
namespace Yacare\CatastroBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yacare\CatastroBundle\Entity\Partida
 *
 * @ORM\Table(name="Catastro_Partida", uniqueConstraints={
 *     @ORM\UniqueConstraint(name="SeccionMacizoParcelaUf", columns={"Seccion", "Macizo", "Parcela", "UnidadFuncional"})
 * }, indexes={
 *         @ORM\Index(name="Catastro_Partida_SeccionMacizoParcelaUf", columns={"Seccion", "Macizo", "Parcela", "UnidadFuncional"}),
 *         @ORM\Index(name="Catastro_Partida_Legajo", columns={"Legajo"}),
 *         @ORM\Index(name="Catastro_Partida_Numero", columns={"Numero"})
 *         }
 * )
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 *
 * UPDATE Catastro_Partida
 * SET Nombre=CONCAT('Sección ', Seccion, ', macizo ', MacizoAlfa, MacizoNum, ', parcela ', ParcelaAlfa, ParcelaNum);
 * UPDATE Catastro_Partida
 * SET DomicilioNumero=NULL WHERE DomicilioNumero=0;
 *
 * UPDATE Inspeccion_RelevamientoAsignacionDetalle SET Partida_id=22345 WHERE Partida_id IN (22346, 22347);
 *
 * DELETE FROM Catastro_Partida
 * WHERE id NOT IN (SELECT DISTINCT Partida_id FROM Inspeccion_RelevamientoAsignacionDetalle);
 *
 * SELECT * FROM Catastro_Partida WHERE Seccion='D' AND Macizo='177' AND Parcela='9' AND UnidadFuncional=0;
 *
 * SELECT COUNT(id), Seccion, Macizo, Parcela, UnidadFuncional FROM Catastro_Partida
 *
 * GROUP BY Seccion, Macizo, Parcela, UnidadFuncional
 * HAVING COUNT(id)>1
 */
class Partida
{
    use \Tapir\BaseBundle\Entity\ConId;
    use \Tapir\BaseBundle\Entity\ConNombre;
    use \Yacare\BaseBundle\Entity\ConDomicilioLocal;
    use \Tapir\BaseBundle\Entity\Versionable;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
    
    /**
     *
     * @var string $Seccion
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $Seccion;
    
    /**
     *
     * @var string $MacizoAlfa
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $MacizoAlfa;
    
    /**
     *
     * @var string $MacizoNum
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $MacizoNum;
    
    /**
     *
     * @var string $Macizo
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $Macizo;
    
    /**
     *
     * @var string $ParcelaAlfa
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $ParcelaAlfa;
    
    /**
     *
     * @var string $ParcelaNum
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $ParcelaNum;
    
    /**
     *
     * @var string $Parcela
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $Parcela;
    
    /**
     * @var int @ORM\Column(type="integer")
     */
    private $UnidadFuncional;
    
    /**
     * @ORM\ManyToOne(targetEntity="\Yacare\BaseBundle\Entity\Persona")
     * @ORM\JoinColumn(nullable=true)
     */
    private $Titular;
    
    /**
     * @ORM\ManyToOne(targetEntity="\Yacare\CatastroBundle\Entity\Zona")
     * @ORM\JoinColumn(nullable=true)
     */
    private $Zona;
    
    /**
     * @var @ORM\Column(type="integer")
     */
    private $Numero;
    
    /**
     * @var @ORM\Column(type="integer")
     */
    private $Legajo;

    public function getSmpu()
    {
        $res = "Sección " . $this->getSeccion() . ", macizo " . $this->getMacizoNum() . $this->getMacizoAlfa() .
             ", parcela " . $this->getParcelaNum() . $this->getParcelaAlfa();
        if ($this->UnidadFuncional > 0) {
            $res .= ', UF ' . $this->UnidadFuncional;
        }
        return $res;
    }

    public function CalcularNombre()
    {
        if ($this->getDomicilioCalle() && $this->getDomicilioCalle()->getId()) {
            
            $this->Nombre = $this->getDomicilioCalle()->getNombre();
            
            if ($this->DomicilioNumero) {
                $this->Nombre .= ' Nº ' . $this->DomicilioNumero;
            }
            if ($this->DomicilioPiso) {
                $this->Nombre .= ', piso ' . $this->DomicilioPiso;
            }
            if ($this->DomicilioPuerta) {
                $this->Nombre .= ', pta. ' . $this->DomicilioPuerta;
            }
            
            $this->Nombre .= " (sección " . $this->getSeccion() . ", macizo " . $this->getMacizoNum() .
                 $this->getMacizoAlfa() . ", parcela " . $this->getParcelaNum() . $this->getParcelaAlfa();
            if ($this->UnidadFuncional > 0) {
                $this->Nombre .= ', UF ' . $this->UnidadFuncional;
            }
            $this->Nombre .= ")";
        } else {
            $this->Nombre = "Sección " . $this->getSeccion() . ", macizo " . $this->getMacizoNum() .
                 $this->getMacizoAlfa() . ", parcela " . $this->getParcelaNum() . $this->getParcelaAlfa();
            if ($this->UnidadFuncional > 0) {
                $this->Nombre .= ', UF ' . $this->UnidadFuncional;
            }
        }
    }

    /**
     * @ignore
     */
    public function getNombre()
    {
        $this->CalcularNombre();
        return $this->Nombre;
    }
    
    /**
     * @ignore
     */
    public function setNombre($Nombre)
    {
        $this->CalcularNombre();
    }

    /**
     * @ignore
     */
    public function getSeccion()
    {
        return $this->Seccion;
    }

    /**
     * @ignore
     */
    public function setSeccion($Seccion)
    {
        $this->Seccion = $Seccion;
        $this->CalcularNombre();
    }

    /**
     * @ignore
     */
    public function getMacizoAlfa()
    {
        return $this->MacizoAlfa;
    }

    /**
     * @ignore
     */
    public function setMacizoAlfa($MacizoAlfa)
    {
        $this->MacizoAlfa = $MacizoAlfa;
        $this->CalcularNombre();
    }

    /**
     * @ignore
     */
    public function getMacizoNum()
    {
        return $this->MacizoNum;
    }

    /**
     * @ignore
     */
    public function setMacizoNum($MacizoNum)
    {
        $this->MacizoNum = $MacizoNum;
        $this->CalcularNombre();
    }

    /**
     * @ignore
     */
    public function getParcelaAlfa()
    {
        return $this->ParcelaAlfa;
    }

    /**
     * @ignore
     */
    public function setParcelaAlfa($ParcelaAlfa)
    {
        $this->ParcelaAlfa = $ParcelaAlfa;
        $this->CalcularNombre();
    }

    /**
     * @ignore
     */
    public function getParcelaNum()
    {
        return $this->ParcelaNum;
    }

    /**
     * @ignore
     */
    public function setParcelaNum($ParcelaNum)
    {
        $this->ParcelaNum = $ParcelaNum;
        $this->CalcularNombre();
    }

    /**
     * @ignore
     */
    public function getMacizo()
    {
        return $this->Macizo;
    }

    /**
     * @ignore
     */
    public function setMacizo($Macizo)
    {
        $this->Macizo = $Macizo;
        $this->CalcularNombre();
    }

    /**
     * @ignore
     */
    public function getParcela()
    {
        return $this->Parcela;
    }

    /**
     * @ignore
     */
    public function setParcela($Parcela)
    {
        $this->Parcela = $Parcela;
        $this->CalcularNombre();
    }

    /**
     * @ignore
     */
    public function getUnidadFuncional()
    {
        return $this->UnidadFuncional;
    }

    /**
     * @ignore
     */
    public function getLegajo()
    {
        return $this->Legajo;
    }

    /**
     * @ignore
     */
    public function setUnidadFuncional($UnidadFuncional)
    {
        $this->UnidadFuncional = $UnidadFuncional;
        $this->CalcularNombre();
    }

    /**
     * @ignore
     */
    public function setLegajo($Legajo)
    {
        $this->Legajo = $Legajo;
    }

    /**
     * @ignore
     */
    public function getNumero()
    {
        return $this->Numero;
    }

    /**
     * @ignore
     */
    public function setNumero($Numero)
    {
        $this->Numero = $Numero;
        $this->CalcularNombre();
    }

    /**
     * @ignore
     */
    public function getZona()
    {
        return $this->Zona;
    }

    /**
     * @ignore
     */
    public function setZona($Zona)
    {
        $this->Zona = $Zona;
    }

    /**
     * @ignore
     */
    public function getTitular()
    {
        return $this->Titular;
    }

    /**
     * @ignore
     */
    public function setTitular($Titular)
    {
        $this->Titular = $Titular;
    }
}

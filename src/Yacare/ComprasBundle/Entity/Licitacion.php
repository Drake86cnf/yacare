<?php

namespace Yacare\ComprasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yacare\ComprasBundle\Entity\Licitacion
 *
 * @ORM\Table(name="Compras_Licitacion")
 * @ORM\Entity
 */
class Licitacion
{
    use \Yacare\BaseBundle\Entity\ConId;
    use \Yacare\BaseBundle\Entity\ConNombre;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
    use \Yacare\BaseBundle\Entity\Versionable;
    use \Yacare\BaseBundle\Entity\Importable;
    use \Yacare\BaseBundle\Entity\ConObs;
    
    /**
     * @var int $Numero
     * @ORM\Column(type="string", nullable=false)
     */
    private $Numero;
    
    /**
     * @var int $Complejidad1
     * @ORM\Column(type="integer", nullable=false)
     * 
     * Compljidad de ..., (0 = baja, 1 = media, 2 = alta)
     */
    private $Complejidad1;
    
    /**
     * @var int $Complejidad2
     * @ORM\Column(type="integer", nullable=false)
     * 
     * Compljidad de ..., (0 = baja, 1 = media, 2 = alta)
     */
    private $Complejidad2;
    
    /**
     * @var int $Complejidad3
     * @ORM\Column(type="integer", nullable=false)
     * 
     * Compljidad de ..., (0 = baja, 1 = media, 2 = alta)
     */
    private $Complejidad3;
    
    
    /**
     * @var int $ComplejidadComputada
     * @ORM\Column(type="integer", nullable=false)
     * 
     * Especifica la complejidad final computada en base a Complejidad1, 2 y 3
     */
    private $ComplejidadComputada;

    
    /**
     * @ORM\ManyToOne(targetEntity="Yacare\OrganizacionBundle\Entity\Departamento")
     * @ORM\JoinColumn(referencedColumnName="id", nullable=true)
     */
    protected $Departamento;
    

    /**
     * @var $PresupuestoOficial
     * @ORM\Column(type="decimal", precision=14, scale=2, nullable=false)
     * 
     * El importe de la licitación
     */
    private $PresupuestoOficial;
    
    
    /**
     * @var $PliegoCoeficiente
     * @ORM\Column(type="decimal", precision=14, scale=2, nullable=false)
     * 
     * El coeficiente es el porcentaje utilizado para calcular el valor del pliego, según ComplejidadComputada
     */
    private $PliegoCoeficiente;
    
    
    /**
     * @var $PliegoValor
     * @ORM\Column(type="decimal", precision=14, scale=2, nullable=false)
     * 
     * El valor del pliego
     */
    private $PliegoValor;
    
    public function ComputarComplejidad() {
        // Hay 27 combinaciones de complejidad (3^3):
        // Hay 3 combinaciones de 3 iguales (111, 222 y 333)
        //   éstas dan como resultado el único valor posible
        // Hay 6 combinaciones de 3 desiguales (123, 321, 213, 231, etc.)
        //   éstas dan como resultado 2, que es el valor promedio
        // El resto son combinaciones 2+1 (122, 313, 332, etc.)
        //   éstas dan como resultado el valor mayoritario (el que se repite 2 veces)
        // A continuación el algoritmo:
        
        if(($this->Complejidad1 == $this->Complejidad2) && ($this->Complejidad2 == $this->Complejidad3)) {
            // Son 3 iguales
            $this->setComplejidadComputada($this->Complejidad1);
        } else if ($this->Complejidad1 == $this->Complejidad2) {
            // 1 y 2 son iguales
            $this->setComplejidadComputada($this->Complejidad1);
        } else if ($this->Complejidad2 == $this->Complejidad3) {
            // 2 y 3 son iguales
            $this->setComplejidadComputada($this->Complejidad2);
        } else if ($this->Complejidad1 == $this->Complejidad3) {
            // 1 y 3 son iguales
            $this->setComplejidadComputada($this->Complejidad1);
        } else {
            // La única que queda es que sean las 3 desiguales
            $this->setComplejidadComputada(1);
        }
        
        switch($this->getComplejidadComputada()) {
            case 0:
                $this->PliegoCoeficiente = 0.2;
                break;
            case 1:
                $this->PliegoCoeficiente = 0.25;
                break;
            case 2:
                $this->PliegoCoeficiente = 0.3;
                break;
        }
        
        $this->PliegoValor = $this->PresupuestoOficial * ($this->PliegoCoeficiente / 100);
    }
    
    
    public function getNumero() {
        return $this->Numero;
    }

    public function setNumero($Numero) {
        $this->Numero = $Numero;
    }

    public function getComplejidad1() {
        return $this->Complejidad1;
    }

    public function setComplejidad1($Complejidad1) {
        $this->Complejidad1 = $Complejidad1;
        $this->ComputarComplejidad();
    }

    public function getComplejidad2() {
        return $this->Complejidad2;
    }

    public function setComplejidad2($Complejidad2) {
        $this->Complejidad2 = $Complejidad2;
        $this->ComputarComplejidad();
    }

    public function getComplejidad3() {
        return $this->Complejidad3;
    }

    public function setComplejidad3($Complejidad3) {
        $this->Complejidad3 = $Complejidad3;
        $this->ComputarComplejidad();
    }

    public function getComplejidadComputada() {
        return $this->ComplejidadComputada;
    }

    public function setComplejidadComputada($ComplejidadComputada) {
        $this->ComplejidadComputada = $ComplejidadComputada;
    }
    
    public function getDepartamento() {
        return $this->Departamento;
    }

    public function setDepartamento($Departamento) {
        $this->Departamento = $Departamento;
    }

    public function getPresupuestoOficial() {
        return $this->PresupuestoOficial;
    }

    public function setPresupuestoOficial($PresupuestoOficial) {
        $this->PresupuestoOficial = $PresupuestoOficial;
        $this->ComputarComplejidad();
    }

    public function getPliegoValor() {
        return $this->PliegoValor;
    }
    
    public function getPliegoCoeficiente() {
        return $this->PliegoCoeficiente;
    }
}

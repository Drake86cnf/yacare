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
    use \Yacare\BaseBundle\Entity\Timestampable;
    use \Yacare\BaseBundle\Entity\Versionable;
    use \Yacare\BaseBundle\Entity\Importable;
    use \Yacare\BaseBundle\Entity\ConObs;
    
    /**
     * @var int $Numero
     * @ORM\Column(type="integer", nullable=false)
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
     * @var $Importe
     * @ORM\Column(type="decimal", precision=14, scale=2, nullable=false)
     * 
     * El importe de la licitación
     */
    private $Importe;
    
    
    /**
     * @var $PliegoCoeficiente
     * @ORM\Column(type="decimal", precision=14, scale=2, nullable=false)
     * 
     * El coeficiente utilizado para calcular el valor del pliego, según ComplejidadComputada
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
        $this->setComplejidadComputada($this->Complejidad1);
        $this->PliegoCoeficiente = 0.2;
        $this->PliegoValor = $this->Importe * ($this->PliegoCoeficiente / 100);
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

    public function getImporte() {
        return $this->Importe;
    }

    public function setImporte($Importe) {
        $this->Importe = $Importe;
        $this->ComputarComplejidad();
    }

    public function getPliegoValor() {
        return $this->PliegoValor;
    }
    
    public function getPliegoCoeficiente() {
        return $this->PliegoCoeficiente;
    }
}

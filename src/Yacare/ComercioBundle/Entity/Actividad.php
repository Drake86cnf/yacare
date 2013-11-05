<?php

namespace Yacare\ComercioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yacare\ComercioBundle\Entity\Actividad
 *
 * @ORM\Entity
 * @ORM\Table(name="Comercio_Actividad")
 */
class Actividad
{
    use \Yacare\BaseBundle\Entity\ConId;
    use \Yacare\BaseBundle\Entity\ConNombre;
    use \Yacare\BaseBundle\Entity\Versionable;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $CodigoAnterior;
    
    /**
     * @var string
     * @ORM\Column(type="string", length=50)
     */
    private $Clanae2010;
    
    /**
     * @ORM\Column(type="string", length=50)
     * Los códigos Clamae2014 tienen el siguiente formato: CDDGCSMM
     *      C   Categoría, alfabética
     *      DD  División, numérica
     *      G   Grupo, numérico
     *      C   Clase, numérica
     *      S   Sub-clase, numérica
     *      MM  Subdivisión del Municipio de Río Grande
     * 
     *      Por ejemplo: R9521000
     */
    private $Clamae2014;

    
     /**
     * @var integer
     * @ORM\Column(type="integer")
     */
    private $Categoria;
    
    /**
     * @var integer
     * @ORM\Column(type="integer", nullable=true)
     */
    private $Cpu;
    
    /**
     * @var bool
     * @ORM\Column(type="boolean")
     */
    private $RequiereDbeh;
    
    /**
     * @var bool
     * @ORM\Column(type="boolean")
     */
    private $RequiereDeyma;
    
     /**
     * @var bool
     * @ORM\Column(type="boolean")
     */
    private $Exento;
    
    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    private $Incluye;
    
    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    private $NoIncluye;
    
    
    public function getCodigoAnterior() {
        return $this->CodigoAnterior;
    }

    public function setCodigoAnterior($CodigoAnterior) {
        $this->Codigo = $CodigoAnterior;
    }
    
    public function getCategoria() {
        return $this->Categoria;
    }

    public function setCategoria($Categoria) {
        $this->Categoria = $Categoria;
    }

    public function getExento() {
        return $this->Exento;
    }

    public function setExento($Exento) {
        $this->Exento = $Exento;
    }

    public function getClamae2014() {
        return $this->Clamae2014;
    }

    public function getCpu() {
        return $this->Cpu;
    }

    public function getRequiereDbeh() {
        return $this->RequiereDbeh;
    }

    public function getRequiereDeyma() {
        return $this->RequiereDeyma;
    }

    public function getIncluye() {
        return $this->Incluye;
    }

    public function getNoIncluye() {
        return $this->NoIncluye;
    }

    public function setClamae2014($Clamae2014) {
        $this->Clamae2014 = $Clamae2014;
        $this->Clanae2010 = substr($this->Clamae2014, 0, 6);
    }

    public function setCpu($Cpu) {
        $this->Cpu = $Cpu;
    }

    public function setRequiereDbeh($RequiereDbeh) {
        $this->RequiereDbeh = $RequiereDbeh;
    }

    public function setRequiereDeyma($RequiereDeyma) {
        $this->RequiereDeyma = $RequiereDeyma;
    }

    public function setIncluye($Incluye) {
        $this->Incluye = $Incluye;
    }

    public function setNoIncluye($NoIncluye) {
        $this->NoIncluye = $NoIncluye;
    }
}

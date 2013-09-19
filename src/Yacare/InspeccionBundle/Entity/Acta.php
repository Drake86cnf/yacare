<?php

namespace Yacare\InspeccionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yacare\InspeccionBundle\Entity\Acta
 *
 * @ORM\Table(name="Inspeccion_Acta")
 * @ORM\Entity
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="SubTipo", type="string")
 * @ORM\DiscriminatorMap({
 *      "\Yacare\InspeccionBundle\Entity\Acta" = "\Yacare\InspeccionBundle\Entity\Acta"
 * })
 */
class Acta
{
    use \Yacare\BaseBundle\Entity\ConId;
    use \Yacare\BaseBundle\Entity\ConNombre;
    use \Yacare\BaseBundle\Entity\Versionable;
        
    /**
     * @ORM\ManyToOne(targetEntity="Yacare\InspeccionBundle\Entity\ActaTalonario")
     */
    protected $Talonario;
    
    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $Numero;
    
    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    private $Fecha;
    
    /**
     * @ORM\ManyToOne(targetEntity="Yacare\BaseBundle\Entity\Persona")
     */
    protected $FuncionarioPrincipal;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    protected $Obs;

    public function getTalonario() {
        return $this->Talonario;
    }

    public function getNumero() {
        return $this->Numero;
    }

    public function getFecha() {
        return $this->Fecha;
    }

    public function getFuncionarioPrincipal() {
        return $this->FuncionarioPrincipal;
    }

    public function getObs() {
        return $this->Obs;
    }

    public function setTalonario($Talonario) {
        $this->Talonario = $Talonario;
    }

    public function setNumero($Numero) {
        $this->Numero = $Numero;
    }

    public function setFecha(\DateTime $Fecha) {
        $this->Fecha = $Fecha;
    }

    public function setFuncionarioPrincipal($FuncionarioPrincipal) {
        $this->FuncionarioPrincipal = $FuncionarioPrincipal;
    }

    public function setObs($Obs) {
        $this->Obs = $Obs;
    }
}

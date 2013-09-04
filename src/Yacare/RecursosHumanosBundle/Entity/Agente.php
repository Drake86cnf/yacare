<?php

namespace Yacare\RecursosHumanosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Yacare\RecursosHumanosBundle\Entity\Agente
 *
 * @ORM\Table(name="Rrhh_Agente", uniqueConstraints={@ORM\UniqueConstraint(name="ImportSrcId", columns={"ImportSrc", "ImportId"})})
 * @ORM\Entity
 */
class Agente
{
    use \Yacare\BaseBundle\Entity\ConId;
    use \Yacare\BaseBundle\Entity\Versionable;
    use \Yacare\BaseBundle\Entity\Suprimible;
    use \Yacare\BaseBundle\Entity\Importable;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;

    /*
    CREATE VIEW rr_hh_agentes AS SELECT * FROM rr_hh.agentes;

    CREATE OR REPLACE VIEW yacare.Rrhh_Agente AS 
        SELECT agentes.legajo AS id, agentes.fechaingre AS FechaIngreso, agentes.nombre AS NombreVisible,
            agentes.username, agentes.salt, agentes.password, agentes.is_active, 
            agentes.NombreSolo as Nombre, agentes.Apellido, agentes.email
        FROM rr_hh.agentes;

    ALTER TABLE rr_hh.agentes
        ADD username VARCHAR(25) NOT NULL DEFAULT '',
        ADD salt VARCHAR(32) NOT NULL DEFAULT '',
        ADD password VARCHAR(40) NOT NULL DEFAULT '',
        ADD NombreSolo VARCHAR(255) NOT NULL DEFAULT '',
        ADD Apellido VARCHAR(255) NOT NULL DEFAULT '',
        CHANGE fechaingre fechaingre DATE NOT NULL,
        CHANGE nombre nombre VARCHAR(255) NOT NULL DEFAULT '',
        CHANGE email email VARCHAR(255) NOT NULL DEFAULT '';

    UPDATE yacare.Rrhh_Agente SET salt=MD5(RAND()) WHERE salt='';
    UPDATE rr_hh.agentes SET Apellido=TRIM(SUBSTRING_INDEX(nombre, ' ', 1)) WHERE NombreSolo='';
    UPDATE rr_hh.agentes SET NombreSolo=TRIM(TRIM(LEADING Apellido FROM nombre)) WHERE NombreSolo='';

    */
    
    /**
     * @ORM\ManyToOne(targetEntity="Yacare\BaseBundle\Entity\Persona")
     * @ORM\JoinColumn(referencedColumnName="id", nullable=false)
     */
    protected $Persona;
    
    /**
     * @var $Categoria
     * @ORM\Column(type="integer", nullable=false)
     */
    private $Categoria;
    
    /**
     * @var $Situacion
     * @ORM\Column(type="integer", nullable=false)
     */
    private $Situacion;
    
    /**
     * @var $Funcion
     * @ORM\Column(type="string")
     */
    private $Funcion;
    
    /**
     * @var \DateTime $FechaIngreso
     * @ORM\Column(type="date", nullable=true)
     * @Assert\Type("\DateTime")
     */
    private $FechaIngreso;
    
    /**
     * @var $Departamento
     * @ORM\ManyToOne(targetEntity="\Yacare\OrganizacionBundle\Entity\Departamento")
     * @ORM\JoinColumn(referencedColumnName="id", nullable=true)
     */
    protected $Departamento;

    
    public function __toString() {
        return $this->getPersona()->getNombreVisible();
    }
    
    public function getPersona() {
        return $this->Persona;
    }

    public function setPersona($Persona) {
        $this->Persona = $Persona;
    }
    
    public function getCategoria() {
        return $this->Categoria;
    }

    public function setCategoria($Categoria) {
        $this->Categoria = $Categoria;
    }

    public function getSituacion() {
        return $this->Situacion;
    }

    public function setSituacion($Situacion) {
        $this->Situacion = $Situacion;
    }

    public function getFuncion() {
        return $this->Funcion;
    }

    public function setFuncion($Funcion) {
        $this->Funcion = $Funcion;
    }

    public function getFechaIngreso() {
        return $this->FechaIngreso;
    }

    public function setFechaIngreso(\DateTime $FechaIngreso) {
        $this->FechaIngreso = $FechaIngreso;
    }

    public function getDepartamento() {
        return $this->Departamento;
    }

    public function setDepartamento($Departamento) {
        $this->Departamento = $Departamento;
    }
}

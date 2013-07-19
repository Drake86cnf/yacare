<?php

namespace Yacare\RecursosHumanosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Yacare\RecursosHumanosBundle\Entity\Agente
 *
 * @ORM\Table(name="Rrhh_Agente", uniqueConstraints={@ORM\UniqueConstraint(name="ImportSrcId", columns={"ImportSrc", "ImportId"})})
 * @ORM\Entity
 */
class Agente
{
    use \Yacare\BaseBundle\Entity\ConId;
    use \Yacare\BaseBundle\Entity\Timestampable;
    use \Yacare\BaseBundle\Entity\Versionable;
    use \Yacare\BaseBundle\Entity\Eliminable;
    use \Yacare\BaseBundle\Entity\Importable;

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
    
    public function getPersona() {
        return $this->Persona;
    }

    public function setPersona($Persona) {
        $this->Persona = $Persona;
    }
}

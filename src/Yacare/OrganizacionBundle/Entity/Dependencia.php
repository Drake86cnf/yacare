<?php

namespace Yacare\OrganizacionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yacare\OrganizacionBundle\Entity\Dependencia
 *
 * @ORM\Table(name="Organizacion_Dependencia")
 * @ORM\Entity
 */
class Dependencia
{
    //use \Yacare\BaseBundle\Entity\Timestampable;
    //use \Yacare\BaseBundle\Entity\Versionable;
    
    /*
    
    UPDATE rr_hh.dependencias SET codigo=999999 WHERE codigo=0;
    ALTER TABLE rr_hh.dependencias CHANGE codigo codigo INT NOT NULL AUTO_INCREMENT FIRST, 
        CHANGE nombre nombre VARCHAR(255) NOT NULL DEFAULT '',
        CHANGE domicilio domicilio VARCHAR(255) NULL DEFAULT '';
    UPDATE rr_hh.dependencias SET codigo=0 WHERE codigo=999999;
    
    CREATE OR REPLACE VIEW yacare.Organizacion_Dependencia AS 
	SELECT codigo AS id, nombre as Nombre, domicilio as Domicilio
	FROM rr_hh.dependencias;
     */
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @var string $Nombre
     * @ORM\Column(type="string", length=255)
     */
    private $Nombre;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Domicilio;
    

    public function getId()
    {
        return $this->id;
    }
    
    public function __toString()
    {
        return $this->getNombre();
    }
    
    public function getNombre() {
        return $this->Nombre;
    }

    public function setNombre($Nombre) {
        $this->Nombre = $Nombre;
    }

    public function getDomicilio() {
        return $this->Domicilio;
    }

    public function setDomicilio($Domicilio) {
        $this->Domicilio = $Domicilio;
    }    
}

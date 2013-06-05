<?php

namespace Yacare\OrganizacionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yacare\OrganizacionBundle\Entity\Secretaria
 *
 * @ORM\Table(name="Organizacion_Secretaria")
 * @ORM\Entity
 */
class Secretaria
{
    /*
    
    UPDATE rr_hh.secretarias SET codigo=999999 WHERE codigo=0;
    ALTER TABLE rr_hh.secretarias CHANGE codigo codigo INT NOT NULL AUTO_INCREMENT FIRST, CHANGE detalle detalle VARCHAR(255) NOT NULL DEFAULT '';
    UPDATE rr_hh.secretarias SET codigo=0 WHERE codigo=999999;
    
    CREATE OR REPLACE VIEW yacare.Organizacion_Secretaria AS 
	SELECT codigo AS id, detalle as Nombre
	FROM rr_hh.secretarias;
     */
    
    //use \Yacare\BaseBundle\Entity\Timestampable;
    //use \Yacare\BaseBundle\Entity\Versionable;

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
     * @ORM\Column(name="Nombre", type="string", length=255)
     */
    private $Nombre;

    public function getId()
    {
        return $this->id;
    }

    public function setNombre($nombre)
    {
        $this->Nombre = $nombre;
    }

    public function getNombre()
    {
        return $this->Nombre;
    }
}

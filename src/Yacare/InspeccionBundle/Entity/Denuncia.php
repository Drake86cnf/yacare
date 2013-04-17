<?php

namespace Yacare\InspeccionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yacare\BaseBundle\Entity\Pais
 *
 * @ORM\Table(name="Inspeccion_Denuncia")
 * @ORM\Entity
 */
class Denuncia
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\id
     * @ORM\GeneratedValue(strategy="AUTO")
     * 
     */
    private $id;
        
    /**
     * @var string $Nombre
     *
     * @ORM\Column(name="Nombre", type="string", length=255)
     */
    private $Nombre;    
  

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set Nombre
     *
     * @param string $nombre
     * @return Pais
     */
    public function setNombre($nombre)
    {
        $this->Nombre = $nombre;
    
        return $this;
    }

    /**
     * Get Nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->Nombre;
    }
}

<?php

namespace Yacare\InspeccionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Relevamiento
 *
 * @ORM\Table("Inspeccion_Relevamiento")
 * @ORM\Entity
 */
class Relevamiento
{
    use \Yacare\BaseBundle\Entity\Timestampable;
    use \Yacare\BaseBundle\Entity\Versionable;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="Nombre", type="string", length=255)
     */
    private $nombre;

    /**
     * @var \DateTime
     * @ORM\Column(name="FechaInicio", type="datetime")
     */
    private $fechaInicio;


    /**
     * Get id
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function getFechaInicio() {
        return $this->fechaInicio;
    }

    public function setFechaInicio(\DateTime $fechaInicio) {
        $this->fechaInicio = $fechaInicio;
    }

}

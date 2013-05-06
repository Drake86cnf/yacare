<?php

namespace Yacare\InspeccionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RelevamientoIncidente
 *
 * @ORM\Table("Inspeccion_RelevamientoIncidente")
 * @ORM\Entity
 */
class RelevamientoIncidnte
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
     * @ORM\Column(type="string", length=255)
     */
    private $Nombre;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $Grupo;


    /**
     * Get id
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    public function getNombre() {
        return $this->Nombre;
    }

    public function setNombre($Nombre) {
        $this->Nombre = $Nombre;
    }

    public function getGrupo() {
        return $this->Grupo;
    }

    public function setGrupo($Grupo) {
        $this->Grupo = $Grupo;
    }
}

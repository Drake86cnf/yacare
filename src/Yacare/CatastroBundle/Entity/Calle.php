<?php

namespace Yacare\CatastroBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yacare\CatastroBundle\Entity\Calle
 *
 * @ORM\Table(name="Catastro_Calle")
 * @ORM\Entity
 */
class Calle
{
    use \Yacare\BaseBundle\Entity\Timestampable;
    use \Yacare\BaseBundle\Entity\Versionable;
    use \Yacare\BaseBundle\Entity\Importable;
    
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * 
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
    
    public function __toString()
    {
        return $this->getNombre();
    }
}

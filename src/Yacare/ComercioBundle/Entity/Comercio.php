<?php

namespace Yacare\ComercioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yacare\ComercioBundle\Entity\Comercio
 *
 * @ORM\Entity
 * @ORM\Table(name="Comercio_Comercio")
 */
class Comercio
{
    use \Yacare\BaseBundle\Entity\ConId;
    use \Yacare\BaseBundle\Entity\ConNombre;
    use \Yacare\BaseBundle\Entity\ConDomicilio;
    use \Yacare\BaseBundle\Entity\Versionable;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
    
    public function __construct()
    {
        $this->Rubros = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * @ORM\ManyToMany(targetEntity="Rubro")
     * @ORM\JoinTable(name="Comercio_Comercio_Rubros")
     */
    private $Rubros;
    
    /**
     * @ORM\ManyToOne(targetEntity="Yacare\BaseBundle\Entity\Persona")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    protected $Titular;
    
    
    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $Titular;
     
    
    public function getRubros() {
        return $this->Rubros;
    }

    public function setRubros($Rubros) {
        $this->Rubros = $Rubros;
    }


    public function getTitular() {
        return $this->Titular;
    }

    public function setTitular($Titular) {
        $this->Titular = $Titular;
    }
}

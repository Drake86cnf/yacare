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
        $this->ActividadesSecundarias = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * @ORM\ManyToOne(targetEntity="Yacare\ComercioBundle\Entity\Actividad")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    protected $ActividadPrincipal;
    
    /**
     * @ORM\ManyToMany(targetEntity="Yacare\ComercioBundle\Entity\Actividad")
     * @ORM\JoinTable(name="Comercio_Comercio_Actividad")
     */
    private $ActividadesSecundarias;
    
    /**
     * @ORM\ManyToOne(targetEntity="Yacare\BaseBundle\Entity\Persona")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    protected $Titular;


    public function getTitular() {
        return $this->Titular;
    }

    public function setTitular($Titular) {
        $this->Titular = $Titular;
    }
    
    public function getActividadPrincipal() {
        return $this->ActividadPrincipal;
    }

    public function setActividadPrincipal($ActividadPrincipal) {
        $this->ActividadPrincipal = $ActividadPrincipal;
    }

    public function getActividadesSecundarias() {
        return $this->ActividadesSecundarias;
    }

    public function setActividadesSecundarias($ActividadesSecundarias) {
        $this->ActividadesSecundarias = $ActividadesSecundarias;
    }
}

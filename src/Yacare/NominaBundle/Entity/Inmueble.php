<?php
namespace Yacare\NominaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Describe un inmueble o establecimiento.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 *
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 * @ORM\Table(name="Nomina_Inmueble")
 */
class Inmueble
{
    use \Tapir\BaseBundle\Entity\ConId;
    use \Tapir\BaseBundle\Entity\ConNombre;
    use \Tapir\BaseBundle\Entity\ConObs;
    use \Yacare\CatastroBundle\Entity\ConPartida;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
    use \Tapir\BaseBundle\Entity\Versionable;

    public function __construct()
    {
        $this->Etiquetas = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Dirección de una página web asociada, si la ubiera.
     *
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $Url;
    
    /**
     * El domicilio declarado, que puede ser diferente al domicilio catastral del local comercial.
     *
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $Domicilio = null;
    
    /**
     * Números telefónicos asociados al inmueble.
     *
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $Telefonos;
    
    /**
     * Horarios de atención.
     *
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $Horario;
    
    /**
     * Las etiquetas asociadas al inmueble.
     *
     * @var \Yacare\NominaBundle\Entity\InmuebleEtiqueta
     *
     * @ORM\ManyToMany(targetEntity="Yacare\NominaBundle\Entity\InmuebleEtiqueta")
     * @ORM\JoinTable(name="Nomina_Inmueble_InmuebleEtiqueta")
     */
    protected $Etiquetas;

    /**
     * @ignore
     */
    public function getUrl()
    {
        return $this->Url;
    }

    /**
     * @ignore
     */
    public function setUrl($Url)
    {
        $this->Url = $Url;
        return $this;
    }

    /**
     * @ignore
     */
    public function getEtiquetas()
    {
        return $this->Etiquetas;
    }

    /**
     * @ignore
     */
    public function setEtiquetas($Etiquetas)
    {
        $this->Etiquetas = $Etiquetas;
        return $this;
    }

    /**
     * @ignore
     */
    public function getTelefonos()
    {
        return $this->Telefonos;
    }

    /**
     * @ignore
     */
    public function setTelefonos($Telefonos)
    {
        $this->Telefonos = $Telefonos;
        return $this;
    }

    /**
     * @ignore
     */
    public function getHorario()
    {
        return $this->Horario;
    }

    /**
     * @ignore
     */
    public function setHorario($Horario)
    {
        $this->Horario = $Horario;
        return $this;
    }

    /**
     * @ignore
     */
    public function getDomicilio()
    {
        return $this->Domicilio;
    }

    /**
     * @ignore
     */
    public function setDomicilio($Domicilio)
    {
        $this->Domicilio = $Domicilio;
        return $this;
    }

}

<?php
namespace Yacare\ComercioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * La clase representa las  etiquetas (requisitos) que se asocian a una
 * actividad comercial.
 * 
 * @author Diaz Alejandro <alediaz.rc@gmail.com>
 *
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 * @ORM\Table(name="Comercio_ActividadEtiquetas")
 */
class ActividadEtiquetas
{
    use \Tapir\BaseBundle\Entity\ConId;
    use \Tapir\BaseBundle\Entity\ConNombre;
    use \Tapir\BaseBundle\Entity\Versionable;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
    use \Tapir\BaseBundle\Entity\ConObs;
    
    
    /**
     * Las actividades que utilizan este requerimiento.
     * 
     * @var Actividad
     * 
     * @ORM\ManyToMany(targetEntity="Actividad",mappedBy="Etiquetas", cascade={"persist"})
     */
    protected $Actividad;
    
    /**
     * Codigo identificador de la etiqueta.
     *
     * @var Codigo
     *
     * @ORM\Column(type="string", nullable=false)
     * 
     */
   private $Codigo;
    
    
    
    
    public function _construct(){
        $this->Actividad= new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @ignore
     */
    public function getActividad()
    {
        return $this->Actividad;
    }

    /**
     * @ignore
     */
    public function setActividad(Actividad $Actividad)
    {
        $this->Actividad = $Actividad;
        return $this;
    }

    /**
     * @ignore
     */
    public function getCodigo()
    {
        return $this->Codigo;
    }

    /**
     * @ignore
     */
    public function setCodigo($Codigo)
    {
        $this->Codigo = $Codigo;
        return $this;
    }
 
}

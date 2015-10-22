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
 * @ORM\Table(name="Comercio_ActividadEtiqueta")
 */
class ActividadEtiqueta
{
    use \Tapir\BaseBundle\Entity\ConId;
    use \Tapir\BaseBundle\Entity\ConNombre;
    use \Tapir\BaseBundle\Entity\Versionable;
    use \Tapir\BaseBundle\Entity\ConObs;
    use \Tapir\BaseBundle\Entity\Suprimible;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
    
    /**
     * Las actividades que utilizan este requerimiento.
     * 
     * @var Actividad
     * 
     * @ORM\ManyToMany(targetEntity="Actividad",mappedBy="Etiquetas", cascade={"persist"})
     */
    protected $Actividades;
    
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
        $this->Actividades = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getActividades()
    {
        return $this->Actividades;
    }

    public function setActividades(Actividad $Actividades)
    {
        $this->Actividades = $Actividades;
        return $this;
    }

    public function getCodigo()
    {
        return $this->Codigo;
    }

    public function setCodigo($Codigo)
    {
        $this->Codigo = $Codigo;
        return $this;
    }

}

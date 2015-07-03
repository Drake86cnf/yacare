<?php
namespace Yacare\RequerimientosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Representa una categoria en la que puede haber requerimientos.
 *
 * @ORM\Table(name="Requerimientos_Requerimiento_Categoria")
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 * 
 * @ORM\Entity(repositoryClass="Yacare\RequerimientosBundle\Entity\CategoriaRepository")
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class Categoria
{
    use \Tapir\BaseBundle\Entity\ConId;
    use \Tapir\BaseBundle\Entity\ConNombre;
    use \Tapir\BaseBundle\Entity\Versionable;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
    
    /**
     * El encargado predeterminado de la categoría.
     *
     * @ORM\ManyToOne(targetEntity="Yacare\BaseBundle\Entity\Persona")
     * @ORM\JoinColumn(referencedColumnName="id", nullable=true)
     */
    private $Encargado;
    
    /**
     * Indica si permite reportes anónimos en esta categoría.
     *
     * @var int
     * @ORM\Column(type="integer", nullable=false)
     */
    private $PermiteAnonimos = 0;


    public function getEncargado()
    {
        return $this->Encargado;
    }

    public function setEncargado($Encargado)
    {
        $this->Encargado = $Encargado;
        return $this;
    }

    public function getPermiteAnonimos()
    {
        return $this->PermiteAnonimos;
    }

    public function setPermiteAnonimos($PermiteAnonimos)
    {
        $this->PermiteAnonimos = $PermiteAnonimos;
        return $this;
    }
}

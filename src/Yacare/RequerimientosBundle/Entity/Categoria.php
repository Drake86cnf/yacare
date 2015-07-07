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
    use \Tapir\BaseBundle\Entity\ConObs;
    use \Tapir\BaseBundle\Entity\ConNombre;
    use \Tapir\BaseBundle\Entity\Versionable;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
    
    /**
     * El encargado predeterminado de la categoría.
     * 
     * Si la categoría tiene un encargado predeterminado, todos los requerimientos que se hagan en esta categoría
     * se asignan automáticamente al encargado.
     *
     * @ORM\ManyToOne(targetEntity="Yacare\BaseBundle\Entity\Persona")
     * @ORM\JoinColumn(referencedColumnName="id", nullable=true)
     */
    private $Encargado;
    
    /**
     * Indica si permite reportes anónimos en esta categoría.
     * 
     * Las categorías que admiten requerimientos anónimos son aquellas que se publican en la web para
     * realizar reclamos a consultas anónimas desde el sitio del Municipio.
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

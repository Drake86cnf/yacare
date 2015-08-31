<?php
namespace Yacare\RequerimientosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Representa una categoria en la que puede haber requerimientos.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 * 
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 * @ORM\Entity(repositoryClass="Yacare\RequerimientosBundle\Entity\CategoriaRepository")
 * @ORM\Table(name="Requerimientos_Requerimiento_Categoria")
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
     * @var \Yacare\BaseBundle\Entity\Persona
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
     * 
     * @ORM\Column(type="integer", nullable=false)
     */
    private $PermiteAnonimos = 0;

    /**
     * @ignore
     */
    public function getEncargado()
    {
        return $this->Encargado;
    }

    /**
     * @ignore
     */
    public function setEncargado($Encargado)
    {
        $this->Encargado = $Encargado;
        return $this;
    }

    /**
     * @ignore
     */
    public function getPermiteAnonimos()
    {
        return $this->PermiteAnonimos;
    }

    /**
     * @ignore
     */
    public function setPermiteAnonimos($PermiteAnonimos)
    {
        $this->PermiteAnonimos = $PermiteAnonimos;
        return $this;
    }
}

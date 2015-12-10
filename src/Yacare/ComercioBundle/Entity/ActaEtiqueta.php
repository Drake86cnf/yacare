<?php
namespace Yacare\ComercioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Representa una falta u otra etiqueta tipificada que por la cual se puede labrar un acta.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 *
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 * @ORM\Table(name="Comercio_ActaEtiqueta")
 */
class ActaEtiqueta
{
    use \Tapir\BaseBundle\Entity\ConId;
    use \Tapir\BaseBundle\Entity\ConNombre;
    use \Tapir\BaseBundle\Entity\Versionable;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
    
    /**
     * El resultado. Por ejemplo de una notificación es una intimación.
     *
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $Resultado;

    /**
     * @ignore
     */
    public function getResultado()
    {
        return $this->Resultado;
    }

    /**
     * @ignore
     */
    public function setResultado($Resultado)
    {
        $this->Resultado = $Resultado;
        return $this;
    }
 
}

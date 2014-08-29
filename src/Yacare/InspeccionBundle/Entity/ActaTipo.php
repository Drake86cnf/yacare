<?php
namespace Yacare\InspeccionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tipo de acta (representa una especie).
 *
 * @ORM\Table(name="Inspeccion_ActaTipo")
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 */
class ActaTipo
{
    use\Tapir\BaseBundle\Entity\ConId;
    use\Tapir\BaseBundle\Entity\ConNombre;
    use\Tapir\BaseBundle\Entity\Versionable;
    use\Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;

    /**
     * Indica el departamento o dependencia a la cual pertenecen este tipo de actas.
     *
     * @see \Yacare\BaseBundle\Organizacion\Departamento @ORM\ManyToOne(targetEntity="Yacare\OrganizacionBundle\Entity\Departamento")
     *      @ORM\JoinColumn(referencedColumnName="id", nullable=true)
     */
    protected $Departamento;

    /**
     * El nombre de la clase (derivada de Acta) con la cual instanciar las actas de este tipo.
     *
     * @var string @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Clase;

    public function getDepartamento()
    {
        return $this->Departamento;
    }

    public function setDepartamento($Departamento)
    {
        $this->Departamento = $Departamento;
    }

    public function getClase()
    {
        return $this->Clase;
    }

    public function setClase($Clase)
    {
        $this->Clase = $Clase;
    }
}

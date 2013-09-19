<?php

namespace Yacare\InspeccionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yacare\InpeccionBundle\Entity\ActaTipo
 *
 * @ORM\Table(name="Inspeccion_ActaTipo")
 * @ORM\Entity
 */
class ActaTipo
{
    use \Yacare\BaseBundle\Entity\ConId;
    use \Yacare\BaseBundle\Entity\ConNombre;
    use \Yacare\BaseBundle\Entity\Versionable;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
    
    /**
     * @ORM\ManyToOne(targetEntity="Yacare\OrganizacionBundle\Entity\Departamento")
     * @ORM\JoinColumn(referencedColumnName="id", nullable=true)
     */
    protected $Departamento;
    
    public function getDepartamento() {
        return $this->Departamento;
    }

    public function setDepartamento($Departamento) {
        $this->Departamento = $Departamento;
    }
}

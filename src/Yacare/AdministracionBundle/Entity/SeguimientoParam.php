<?php
namespace Yacare\AdministracionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Representa un conjunto de parámetros para un seguimiento.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 *
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 * @ORM\Table(name="Administracion_SeguimientoParam")
 */
class SeguimientoParam
{
    use \Tapir\BaseBundle\Entity\ConId;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
    
    /**
     * La clase de entidad a la cual pertenece el seguimiento.
     * 
     * @var string
     * 
     * @ORM\Column(type="string", nullable=false)
     */
    protected $EntidadClase;

    /**
     * El departamento que normalmente inicia el seguimiento.
     *
     * @var \Yacare\OrganizacionBundle\Entity\Departamento
     *
     * @ORM\ManyToOne(targetEntity="Yacare\OrganizacionBundle\Entity\Departamento")
     * @ORM\JoinColumn(referencedColumnName="id", nullable=true)
     */
    protected $DepartamentoInicial;
    
    /**
     * Los departamentos que intervienen y a los cuales se les puede enviar el ítem.
     *
     * @var \Yacare\OrganizacionBundle\Entity\Departamento
     *
     * @ORM\ManyToMany(targetEntity="Yacare\OrganizacionBundle\Entity\Departamento")
     * @ORM\JoinTable(name="Administracion_SeguimientoParam_Departamento")
     */
    protected $Departamentos;

    /**
     * @ignore
     */
    public function getEntidadClase()
    {
        return $this->EntidadClase;
    }

    /**
     * @ignore
     */
    public function setEntidadClase($EntidadClase)
    {
        $this->EntidadClase = $EntidadClase;
        return $this;
    }

    /**
     * @ignore
     */
    public function getDepartamentoInicial()
    {
        return $this->DepartamentoInicial;
    }

    /**
     * @ignore
     */
    public function setDepartamentoInicial($DepartamentoInicial)
    {
        $this->DepartamentoInicial = $DepartamentoInicial;
        return $this;
    }

    /**
     * @ignore
     */
    public function getDepartamentos()
    {
        return $this->Departamentos;
    }

    /**
     * @ignore
     */
    public function setDepartamentos($Departamentos)
    {
        $this->Departamentos = $Departamentos;
        return $this;
    }
}

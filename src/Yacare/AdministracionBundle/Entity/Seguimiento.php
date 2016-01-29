<?php
namespace Yacare\AdministracionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Representa un expediente.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 *
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 * @ORM\Table(name="Administracion_Seguimiento")
 */
class Seguimiento
{
    use \Tapir\BaseBundle\Entity\ConId;
    use \Tapir\BaseBundle\Entity\ConNombre;
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
     * El id de entidad a la cual pertenece el seguimiento.
     *
     * @var string
     *
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $EntidadId;
    
    /**
     * La persona que envía.
     * 
     * @var \Yacare\BaseBundle\Entity\Persona
     *
     * @ORM\ManyToOne(targetEntity="Yacare\BaseBundle\Entity\Persona")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    protected $PersonaEnvia;
    
    /**
     * La persona que recibe.
     *
     * @var \Yacare\BaseBundle\Entity\Persona
     *
     * @ORM\ManyToOne(targetEntity="Yacare\BaseBundle\Entity\Persona")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    protected $PersonaRecibe;
    
    /**
     * El departamento al cual es enviado.
     *
     * @var \Yacare\OrganizacionBundle\Entity\Departamento
     *
     * @ORM\ManyToOne(targetEntity="Yacare\OrganizacionBundle\Entity\Departamento")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    protected $DepartamentoDestino;

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
    public function getEntidadId()
    {
        return $this->EntidadId;
    }

    /**
     * @ignore
     */
    public function setEntidadId($EntidadId)
    {
        $this->EntidadId = $EntidadId;
        return $this;
    }

    /**
     * @ignore
     */
    public function getPersonaEnvia()
    {
        return $this->PersonaEnvia;
    }

    /**
     * @ignore
     */
    public function setPersonaEnvia($PersonaEnvia)
    {
        $this->PersonaEnvia = $PersonaEnvia;
        return $this;
    }

    /**
     * @ignore
     */
    public function getPersonaRecibe()
    {
        return $this->PersonaRecibe;
    }

    /**
     * @ignore
     */
    public function setPersonaRecibe($PersonaRecibe)
    {
        $this->PersonaRecibe = $PersonaRecibe;
        return $this;
    }

    /**
     * @ignore
     */
    public function getDepartamentoDestino()
    {
        return $this->DepartamentoDestino;
    }

    /**
     * @ignore
     */
    public function setDepartamentoDestino($DepartamentoDestino)
    {
        $this->DepartamentoDestino = $DepartamentoDestino;
        return $this;
    }
}

<?php
namespace Yacare\TramitesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Agrega la propiedad de Titular a una entidad.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
trait ConTitular
{

    /**
     * @ORM\ManyToOne(targetEntity="Yacare\BaseBundle\Entity\Persona")
     * @ORM\JoinColumn(referencedColumnName="id")
     * 
     * @Symfony\Component\Validator\Constraints\NotNull(message="Debe seleccionar el titular.")
     */
    protected $Titular;

    public function getTitular()
    {
        return $this->Titular;
    }

    public function setTitular($Titular)
    {
        $this->Titular = $Titular;
    }
}
<?php
namespace Yacare\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Trait para entidades que tienen una fecha de vencimiento.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 * @author Ezequiel Riquelme <rezequiel.tdf@gmail.com>
 */
trait ConFechaValidezHasta
{
    /**
     * La fecha de vencimiento.
     *
     * @var \Date
     *
     * @ORM\Column(type="date", nullable=true)
     * @Assert\Date(message="Por favor proporcione una fecha de validez.")
     */
    private $FechaValidezHasta;

    /**
     * @ignore
     */
    public function getFechaValidezHasta()
    {
        return $this->FechaValidezHasta;
    }

    /**
     * @ignore
     */
    public function setFechaValidezHasta(\DateTime $FechaValidezHasta)
    {
        $this->FechaValidezHasta = $FechaValidezHasta;
        return $this;
    }
}

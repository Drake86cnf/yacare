<?php
namespace Yacare\TramitesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait para cosas que tienen una fecha de vencimiento.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
trait ConVencimiento
{
    /**
     * La fecha de vencimiento.
     *
     * @var \DateTime
     * 
     * @ORM\Column(type="date", nullable=true)
     */
    private $Vencimiento;

    /**
     * @ignore
     */
    public function getVencimiento()
    {
        return $this->Vencimiento;
    }

    /**
     * @ignore
     */
    public function setVencimiento(\DateTime $Vencimiento = null)
    {
        $this->Vencimiento = $Vencimiento;
    }
}

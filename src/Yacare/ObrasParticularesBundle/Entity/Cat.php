<?php
namespace Yacare\ObrasParticularesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yacare\ObrasParticularesBundle\Entity\Cat
 *
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 * @ORM\Table(name="ObrasParticulares_Cat")
 */
class Cat extends \Yacare\TramitesBundle\Entity\Comprobante
{
    use \Yacare\TramitesBundle\Entity\ConVencimiento;

    /**
     * @ORM\ManyToOne(targetEntity="Yacare\ComercioBundle\Entity\Local")
     * @ORM\JoinColumn(referencedColumnName="id", nullable=false)
     */
    protected $Local;

    public function getLocal()
    {
        return $this->Local;
    }

    public function setLocal($Local)
    {
        $this->Local = $Local;
    }
}

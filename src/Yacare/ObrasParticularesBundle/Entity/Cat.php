<?php
namespace Yacare\ObrasParticularesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Representa un certificado de aptitud técnica.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 *
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 * @ORM\Table(name="ObrasParticulares_Cat")
 */
class Cat extends \Yacare\TramitesBundle\Entity\Comprobante
{
    use \Yacare\BaseBundle\Entity\ConFechaValidezHasta;
    
    /**
     * El local.
     * 
     * @var \Yacare\ComercioBundle\Entity\Local
     * 
     * @ORM\ManyToOne(targetEntity="Yacare\ComercioBundle\Entity\Local")
     * @ORM\JoinColumn(referencedColumnName="id", nullable=false)
     */
    protected $Local;

    /**
     * @ignore
     */
    public function getLocal()
    {
        return $this->Local;
    }

    /**
     * @ignore
     */
    public function setLocal($Local)
    {
        $this->Local = $Local;
    }
}

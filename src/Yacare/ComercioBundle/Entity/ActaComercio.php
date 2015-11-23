<?php
namespace Yacare\ComercioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;

/**
 * Representa un acta de comercio.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 *
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 * @ORM\Table(name="Comercio_ActaComercio")
 */
class ActaComercio extends \Yacare\InspeccionBundle\Entity\Acta
{
    /**
     * El comercio asociado a esta acta.
     * 
     * @var \Yacare\ComercioBundle\Entity\Comercio
     *
     * @ORM\ManyToOne(targetEntity="Yacare\ComercioBundle\Entity\Comercio", inversedBy="Actas")
     * @ORM\JoinColumn(nullable=true)
     */
    protected $Comercio;
    

    /**
     * @ignore
     */
    public function getComercio()
    {
        return $this->Comercio;
    }

    /**
     * @ignore
     */
    public function setComercio($Comercio)
    {
        $this->Comercio = $Comercio;
        return $this;
    } 
}

<?php
namespace Yacare\BromatologiaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yacare\BromatologiaBundle\Entity\ActaRutinaControlPlagas
 *
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 * @ORM\Table(name="Bromatologia_ActaRutinaControlPlagas")
 */
abstract class ActaRutinaControlPlagas extends \Yacare\BromatologiaBundle\Entity\ActaRutina
{

    /**
     * @ORM\ManyToOne(targetEntity="Yacare\ComercioBundle\Entity\Local")
     * @ORM\JoinColumn(referencedColumnName="id")
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

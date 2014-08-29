<?php
namespace Yacare\ComercioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

trait ConDatosComercio
{
    use\Yacare\ComercioBundle\Entity\ConActividades;

    /**
     * @ORM\ManyToOne(targetEntity="Yacare\ComercioBundle\Entity\Local")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    protected $Local;

    public function getInmueble()
    {
        return $this->Local;
    }

    public function getLocal()
    {
        return $this->Local;
    }

    public function setLocal($Local)
    {
        $this->Local = $Local;
    }
}

<?php
namespace Yacare\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Agrega la capacidad de tener archivos adjuntos.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
trait ConAdjuntos
{
    /**
     * El archivo adjunto.
     * 
     * @var Adjunto
     * 
     * @ORM\ManyToMany(targetEntity="\Yacare\BaseBundle\Entity\Adjunto", cascade={ "persist" })
     */
    protected $Adjuntos;

    public function __construct()
    {
        $this->Adjuntos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @ignore
     */
    public function getAdjuntos()
    {
        return $this->Adjuntos;
    }

    /**
     * @ignore
     */
    public function setAdjuntos($Adjuntos)
    {
        $this->Adjuntos = $Adjuntos;
    }
}

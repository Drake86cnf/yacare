<?php
namespace Yacare\CatastroBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Agrega la capacidad de estar asociado a una partida inmobiliaria.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
trait ConPartida
{
    /**
     * La partida inmobiliaria.
     * 
     * @var Partida.
     * 
     * @ORM\ManyToOne(targetEntity="\Yacare\CatastroBundle\Entity\Partida")
     * @ORM\JoinColumn(nullable=true)
     */
    protected $Partida;

    /**
     * @ignore
     */
    public function getPartida()
    {
        return $this->Partida;
    }

    /**
     * @ignore
     */
    public function setPartida($Partida)
    {
        $this->Partida = $Partida;
    }
}

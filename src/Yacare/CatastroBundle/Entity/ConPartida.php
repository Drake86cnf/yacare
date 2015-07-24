<?php
namespace Yacare\CatastroBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Agrega la capacidad de estar asociado a una partida inmobiliaria.
 */
trait ConPartida
{
    /**
     * @ORM\ManyToOne(targetEntity="\Yacare\CatastroBundle\Entity\Partida")
     * @ORM\JoinColumn(nullable=true)
     */
    protected $Partida;

    public function getPartida()
    {
        return $this->Partida;
    }

    public function setPartida($Partida)
    {
        $this->Partida = $Partida;
    }
}

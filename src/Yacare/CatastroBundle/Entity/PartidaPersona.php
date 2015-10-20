<?php
namespace Yacare\CatastroBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Representa una persona que está relacionada con una partida.
 *
 * ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 * @ORM\Table(name="Catastro_PartidaPersona")
 */
class PartidaPersona
{
    //use \Tapir\BaseBundle\Entity\ConId;
    
    /**
     * La partida inmobiliaria.
     * 
     * @var Partida
     * 
     * @ORM\ManyToOne(targetEntity="\Yacare\CatastroBundle\Entity\Partida")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $Partida;
    
    /**
     * La persona relacionada.
     *
     * @var \Yacare\BaseBundle\Entity\Persona
     *
     * @ORM\ManyToOne(targetEntity="\Yacare\BaseBundle\Entity\Persona")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Persona;
    
    
    /**
     * La relación de la presona con la partida.
     * 
     * @var string
     * 
     * @ORM\Column(type="string", length=50, nullable=false)
     */
    private $Relacion;
    
    /**
     * El tipo de relación de la presona con la partida.
     *
     * @var int
     * 
     * @ORM\Column(type="integer", nullable=false)
     */
    private $TipoRelacion;

    /**
     * @return the Partida
     */
    public function getPartida()
    {
        return $this->Partida;
    }

    /**
     * @param Partida $Partida
     */
    public function setPartida(Partida $Partida)
    {
        $this->Partida = $Partida;
        return $this;
    }

    /**
     * @return the Persona
     */
    public function getPersona()
    {
        return $this->Persona;
    }

    /**
     * @param  $Persona
     */
    public function setPersona($Persona)
    {
        $this->Persona = $Persona;
        return $this;
    }

    /**
     * @return the string
     */
    public function getRelacion()
    {
        return $this->Relacion;
    }

    /**
     * @param string $Relacion
     */
    public function setRelacion($Relacion)
    {
        $this->Relacion = $Relacion;
        return $this;
    }

    /**
     * @return the int
     */
    public function getTipoRelacion()
    {
        return $this->TipoRelacion;
    }

    /**
     * @param int $TipoRelacion
     */
    public function setTipoRelacion($TipoRelacion)
    {
        $this->TipoRelacion = $TipoRelacion;
        return $this;
    }
 
    
    
}
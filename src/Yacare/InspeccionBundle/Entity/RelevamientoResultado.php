<?php

namespace Yacare\InspeccionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yacare\InspeccionBundle\Entity\RelevamientoResultado
 *
 * @ORM\Table(name="Inspeccion_RelevamientoResultado")
 * @ORM\Entity
 */
class RelevamientoResultado
{
    use \Yacare\BaseBundle\Entity\Timestampable;
    use \Yacare\BaseBundle\Entity\Versionable;
    use \Yacare\BaseBundle\Entity\ConImagen;

    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * 
     */
    private $id;

    /**
     * @var string $Fecha
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $Fecha;
    
    
    /**
     * @ORM\ManyToOne(targetEntity="Relevamiento")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    protected $Relevamiento;
    
    
    /**
     * @ORM\ManyToOne(targetEntity="Yacare\CatastroBundle\Entity\Partida")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    protected $Partida;

    /**
     * @ORM\ManyToOne(targetEntity="Yacare\InspeccionBundle\Entity\RelevamientoResultadoTipo")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    protected $ResultadoTipo;


    /**
     * Get id
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
    
    public function getFecha() {
        return $this->Fecha;
    }

    public function setFecha($Fecha) {
        $this->Fecha = $Fecha;
    }

    public function getRelevamiento() {
        return $this->Relevamiento;
    }

    public function setRelevamiento($Relevamiento) {
        $this->Relevamiento = $Relevamiento;
    }

    public function getPartida() {
        return $this->Partida;
    }

    public function setPartida($Partida) {
        $this->Partida = $Partida;
    }

    public function getResultadoTipo() {
        return $this->ResultadoTipo;
    }

    public function setResultadoTipo($ResultadoTipo) {
        $this->ResultadoTipo = $ResultadoTipo;
    }
}

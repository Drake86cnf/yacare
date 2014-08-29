<?php
namespace Yacare\ObrasParticularesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Representa un acta de inspección, infracción, notificación o compromiso.
 *
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 * @ORM\Table(name="ObrasParticulares_Acta")
 */
class Acta extends \Yacare\InspeccionBundle\Entity\Acta
{

    /**
     * El comercio asociado al acta, en caso de ser un acta de comercio o null si es un acta de obra.
     *
     * @ORM\ManyToOne(targetEntity="Yacare\ComercioBundle\Entity\Comercio")
     * @ORM\JoinColumn(nullable=true)
     */
    protected $Comercio;

    /**
     * La partida asociada al acta.
     *
     * @ORM\ManyToOne(targetEntity="Yacare\CatastroBundle\Entity\Partida")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $Partida;

    /**
     * El estado de avance la obra para las actas de obra o 0 para las actas de comercio.
     *
     * @var integer @ORM\Column(type="integer")
     */
    protected $EstadoAvance;

    /**
     * El plazo para la regularización, si corresponde.
     *
     * Se aplica a todos los subtipos excepto "inspección".
     *
     * @var integer @ORM\Column(type="integer")
     */
    protected $Plazo;

    public function getComercio()
    {
        return $this->Comercio;
    }

    public function setComercio($Comercio)
    {
        $this->Comercio = $Comercio;
    }

    public function getPartida()
    {
        return $this->Partida;
    }

    public function setPartida($Partida)
    {
        $this->Partida = $Partida;
    }

    public function getEstadoAvance()
    {
        return $this->EstadoAvance;
    }

    public function getPlazo()
    {
        return $this->Plazo;
    }

    public function setEstadoAvance($EstadoAvance)
    {
        $this->EstadoAvance = $EstadoAvance;
    }

    public function setPlazo($Plazo)
    {
        $this->Plazo = $Plazo;
    }
}

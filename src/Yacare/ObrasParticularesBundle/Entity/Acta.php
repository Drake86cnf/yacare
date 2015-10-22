<?php
namespace Yacare\ObrasParticularesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Representa un acta de inspección, infracción, notificación o compromiso.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 *
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 * @ORM\Table(name="ObrasParticulares_Acta")
 */
class Acta extends \Yacare\InspeccionBundle\Entity\Acta
{
    /**
     * La falta tipificada, o null si no está tipificada.
     *
     * @var \Yacare\ObrasParticularesBundle\Entity\TipoFalta
     *
     * @ORM\ManyToOne(targetEntity="Yacare\ObrasParticularesBundle\Entity\TipoFalta")
     * @ORM\JoinColumn(nullable=true)
     */
    protected $TipoFalta;
    
    /**
     * El comercio asociado al acta, en caso de ser un acta de comercio o null si es un acta de obra.
     * 
     * @var \Yacare\ComercioBundle\Entity\Comercio
     *
     * @ORM\ManyToOne(targetEntity="Yacare\ComercioBundle\Entity\Comercio")
     * @ORM\JoinColumn(nullable=true)
     */
    protected $Comercio;
    
    /**
     * La partida asociada al acta.
     * 
     * @var \Yacare\CatastroBundle\Entity\Partida
     *
     * @ORM\ManyToOne(targetEntity="Yacare\CatastroBundle\Entity\Partida")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $Partida;
    
    /**
     * El estado de avance la obra para las actas de obra o 0 para las actas de comercio.
     *
     * @var integer 
     * 
     * @ORM\Column(type="integer")
     */
    protected $EstadoAvance;
    
    /**
     * Indica si todas las observaciones del acta en cuestion fueron cumplidas.
     *
     * @var integer 
     * 
     * @ORM\Column(type="integer")
     */
    protected $Estado;
    
    /**
     * El plazo para la regularización, si corresponde.
     *
     * Se aplica a todos los subtipos excepto "inspección".
     *
     * @var integer 
     * 
     * @ORM\Column(type="integer")
     */
    protected $Plazo;
    
    /**
     * El profesional a cargo de la obra, en caso que corresponda.
     *
     * Se aplica a todos los subtipos excepto "inspección".
     * 
     * @var \Yacare\ObrasParticularesBundle\Entity\Matriculado
     *
     * @ORM\ManyToOne(targetEntity="Yacare\ObrasParticularesBundle\Entity\Matriculado")
     * @ORM\JoinColumn(nullable=true)
     */
    protected $Profesional;
    

    /**
     * @ignore
     */
    public function getProfesional()
    {
        return $this->Profesional;
    }

    /**
     * @ignore
     */
    public function setProfesional($Profesional)
    {
        $this->Profesional = $Profesional;
    }

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
    }

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

    /**
     * @ignore
     */
    public function getEstadoAvance()
    {
        return $this->EstadoAvance;
    }

    /**
     * @ignore
     */
    public function getPlazo()
    {
        return $this->Plazo;
    }

    /**
     * @ignore
     */
    public function setEstadoAvance($EstadoAvance)
    {
        $this->EstadoAvance = $EstadoAvance;
    }

    /**
     * @ignore
     */
    public function setPlazo($Plazo)
    {
        $this->Plazo = $Plazo;
    }

    /**
     * @return the TipoFalta
     */
    public function getTipoFalta()
    {
        return $this->TipoFalta;
    }

    /**
     * @param  $TipoFalta
     */
    public function setTipoFalta($TipoFalta)
    {
        $this->TipoFalta = $TipoFalta;
        return $this;
    }

    /**
     * @return the integer
     */
    public function getEstado()
    {
        return $this->Estado;
    }

    /**
     * @param  $Estado
     */
    public function setEstado($Estado)
    {
        $this->Estado = $Estado;
        return $this;
    }
}

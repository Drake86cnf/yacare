<?php
namespace Yacare\InspeccionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\DBAL\Types;

/**
 * Detalle de asignación.
 *
 * @see RelevamientoAsignacion
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 *        
 * @ORM\Table(name="Inspeccion_RelevamientoAsignacionDetalle")
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 */
class RelevamientoAsignacionDetalle
{
    use \Tapir\BaseBundle\Entity\ConId;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
    use \Tapir\BaseBundle\Entity\Versionable;
    use \Tapir\BaseBundle\Entity\Suprimible;
    
    /**
     * @ORM\ManyToOne(targetEntity="Relevamiento")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    protected $Relevamiento;
    
    /**
     * @ORM\ManyToOne(targetEntity="RelevamientoAsignacion", cascade={"remove"}, inversedBy="Detalles")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    protected $Asignacion;
    
    /**
     * @ORM\ManyToOne(targetEntity="Yacare\BaseBundle\Entity\Persona")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    protected $Encargado;
    
    /**
     * @ORM\ManyToOne(targetEntity="Yacare\CatastroBundle\Entity\Partida")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    protected $Partida;
    
    /**
     * @var string 
     * 
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $PartidaSeccion;
    
    /**
     * @var string 
     * 
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $PartidaMacizo;
    
    /**
     * @var string 
     * 
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $PartidaParcela;
    
    /**
     * @ORM\ManyToOne(targetEntity="Yacare\CatastroBundle\Entity\Calle")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    protected $PartidaCalle;
    
    /**
     * @var string 
     * 
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $PartidaCalleNombre;
    
    /**
     * @var integer 
     * 
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $PartidaCalleNumero;
    
    /**
     * @var integer 
     * 
     * @ORM\Column(type="integer")
     */
    protected $ResultadosCantidad = 0;

    /**
     * @ignore
     */
    public function getRelevamiento()
    {
        return $this->Relevamiento;
    }

    /**
     * @ignore
     */
    public function setRelevamiento($Relevamiento)
    {
        $this->Relevamiento = $Relevamiento;
    }

    /**
     * @ignore
     */
    public function getAsignacion()
    {
        return $this->Asignacion;
    }

    /**
     * @ignore
     */
    public function setAsignacion($Asignacion)
    {
        $this->Asignacion = $Asignacion;
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
    public function getPartidaSeccion()
    {
        return $this->PartidaSeccion;
    }

    /**
     * @ignore
     */
    public function setPartidaSeccion($PartidaSeccion)
    {
        $this->PartidaSeccion = $PartidaSeccion;
    }

    /**
     * @ignore
     */
    public function getPartidaMacizo()
    {
        return $this->PartidaMacizo;
    }

    /**
     * @ignore
     */
    public function setPartidaMacizo($PartidaMacizo)
    {
        $this->PartidaMacizo = $PartidaMacizo;
    }

    /**
     * @ignore
     */
    public function getPartidaParcela()
    {
        return $this->PartidaParcela;
    }

    /**
     * @ignore
     */
    public function setPartidaParcela($PartidaParcela)
    {
        $this->PartidaParcela = $PartidaParcela;
    }

    /**
     * @ignore
     */
    public function getPartidaCalle()
    {
        return $this->PartidaCalle;
    }

    /**
     * @ignore
     */
    public function setPartidaCalle($PartidaCalle)
    {
        $this->PartidaCalle = $PartidaCalle;
    }

    /**
     * @ignore
     */
    public function getPartidaCalleNumero()
    {
        return $this->PartidaCalleNumero;
    }

    /**
     * @ignore
     */
    public function setPartidaCalleNumero($PartidaCalleNumero)
    {
        $this->PartidaCalleNumero = $PartidaCalleNumero;
    }

    /**
     * @ignore
     */
    public function getEncargado()
    {
        return $this->Encargado;
    }

    /**
     * @ignore
     */
    public function setEncargado($Encargado)
    {
        $this->Encargado = $Encargado;
    }

    /**
     * @ignore
     */
    public function getPartidaCalleNombre()
    {
        return $this->PartidaCalleNombre;
    }

    /**
     * @ignore
     */
    public function setPartidaCalleNombre($PartidaCalleNombre)
    {
        $this->PartidaCalleNombre = $PartidaCalleNombre;
    }

    /**
     * @ignore
     */
    public function getResultadosCantidad()
    {
        return $this->ResultadosCantidad;
    }

    /**
     * @ignore
     */
    public function setResultadosCantidad($ResultadosCantidad)
    {
        $this->ResultadosCantidad = $ResultadosCantidad;
    }
}

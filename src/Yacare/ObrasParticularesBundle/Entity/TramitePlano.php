<?php
namespace Yacare\ObrasParticularesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Yacare\TramitesBundle\Entity\Tramite;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Representa una previa.
 *
 * @author Ezequiel Riquelme <rezequiel.tdf@gmail.com>
 *
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 * @ORM\Table(name="ObrasParticulares_TramitePlano")
 */
class TramitePlano extends \Yacare\TramitesBundle\Entity\Tramite
{
    use \Yacare\AdministracionBundle\Entity\ConExpediente;
    use \Yacare\CatastroBundle\Entity\ConPartida;
    use \Yacare\ObrasParticularesBundle\Entity\ConProfesional;

    public function __construct()
    {
        parent::__construct();
        
        $this->Titular = new \Yacare\BaseBundle\Entity\Persona();
        $this->ObraDestinos = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * El número de la previa correspondiete al trámite.
     *
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=false)
     */
    private $NumeroPrevia;
    
    /**
     * El o los destinos de una obra.
     *
     * @var \Yacare\ObrasParticularesBundle\Entity\ObraDestino
     *
     * @ORM\ManyToMany(targetEntity="Yacare\ObrasParticularesBundle\Entity\ObraDestino")
     * @ORM\JoinTable(name="ObrasParticulares_TramitePlano_ObraDestino",
     *     joinColumns={ @ORM\JoinColumn(name="Tramite_id", referencedColumnName="id", nullable=true) })
     */
    protected $ObraDestinos;
    
    /**
     * El o los tipos del plano declarado por ejemplo (Obra nueva y ampliación)
     * 
     * @var integer
     * 
     * @ORM\Column(type ="integer")
     * 
     */
    private $PlanoTipo = 1;
    
    /**
     * Indica la fecha del PermisoInicio de Obra en caso que lo tenga
     * 
     * @var date
     * 
     * @ORM\Column(type="date",nullable=true)
     * 
     */
    private $InicioDeObra;
    
    /**
     * La superficie proyectada del plano
     * 
     * @var float
     * 
     * @ORM\Column(type="float")
     * 
     */
    private $SuperficieProyectada = 0;
    
    /**
     * La superficie aprobada del plano
     *
     * @var float
     *
     * @ORM\Column(type="float")
     *
     */
    private $SuperficieAprobada = 0;
    
    /**
     * La superficie relevada del plano
     *
     * @var float
     *
     * @ORM\Column(type="float")
     *
     */
    private $SuperficieRelevada = 0;
    
    /**
     * Fecha de aprobada la previa.
     * 
     * @var \DateTime
     * 
     * @ORM\Column(type="datetime", nullable=true)
     * @Assert\Range(
     *     min = "-2 years",
     *     max = "now",
     *     minMessage = "Debe ingresar una fecha dentro de los dos últimos años.",
     *     maxMessage = "Debe ingresar una fecha dentro de los dos últimos años." 
     * )
     */
    private $FechaAprobadaPrevia = null;

    /**
     * Devuelve si fueron aprobados los requisitos de la previa de un trámite.
     * 
     * @return boolen
     */
    public function TienePreviaAprobada() 
    {
        //TODO: construir comprobación de requisitos aprobados (para la previa)        
        return true;
    }
    
    /**
     * Consulta si el trámite tiene hecho el visado de Obras Particulares.
     * 
     * @return boolean
     */
    public function TieneVisadoOp()
    {
        $Estado = $this->ObtenerEstadoRequisitoPorCodigo('req_visado_obrasparticulares');
        
        return ($Estado && $Estado->getEstado() == 100);
    }
    
    public function getTipo()
    {
        switch ($this->getPlanoTipo()) {
            case 1:
                return 'Relevamiento';
            case 2:
                return 'Conforme a obra';
            case 4:
                return 'Obra nueva';
            case 5:
                return 'Relevamiento y ampliación';
            case 6:
                return 'Conforme a obra y ampliación';
        }
    }

    public function __toString()
    {
        return 'Trámite de Planos Nº ' . $this->getId();
    }

    /**
     * @ignore
     */
    public function getObraSuperficie()
    {
        return $this->ObraSuperficie;
    }

    /**
     * @ignore
     */
    public function setObraSuperficie($ObraSuperficie)
    {
        $this->ObraSuperficie = $ObraSuperficie;
        return $this;
    }

    /**
     * @ignore
     */
    public function getObraDestinos()
    {
        return $this->ObraDestinos;
    }

    /**
     * @ignore
     */
    public function setObraDestinos($ObraDestinos)
    {
        $this->ObraDestinos = $ObraDestinos;
        return $this;
    }

    /**
     * @ignore
     */
    public function getPlanoTipo()
    {
        return $this->PlanoTipo;
    }

    /**
     * @ignore
     */
    public function setPlanoTipo($PlanoTipo)
    {
        $this->PlanoTipo = $PlanoTipo;
        return $this;
    }

    /**
     * @ignore
     */
    public function getSuperficieProyectada()
    {
        return $this->SuperficieProyectada;
    }

    /**
     * @ignore
     */
    public function setSuperficieProyectada($SuperficieProyectada)
    {
        $this->SuperficieProyectada = $SuperficieProyectada;
        return $this;
    }

    /**
     * @ignore
     */
    public function getSuperficieAprobada()
    {
        return $this->SuperficieAprobada;
    }

    /**
     * @ignore
     */
    public function setSuperficieAprobada($SuperficieAprobada)
    {
        $this->SuperficieAprobada = $SuperficieAprobada;
        return $this;
    }

    /**
     * @ignore
     */
    public function getSuperficieRelevada()
    {
        return $this->SuperficieRelevada;
    }

    /**
     * @ignore
     */
    public function setSuperficieRelevada($SuperficieRelevada)
    {
        $this->SuperficieRelevada = $SuperficieRelevada;
        return $this;
    }

    /**
     * @ignore
     */
    public function getInicioDeObra()
    {
        return $this->InicioDeObra;
    }

    /**
     * @ignore
     */
    public function setInicioDeObra($InicioDeObra)
    {
        $this->InicioDeObra = $InicioDeObra;
        return $this;
    }

    /**
     * @ignore
     */
    public function getNumeroPrevia()
    {
        return $this->NumeroPrevia;
    }

    /**
     * @ignore
     */
    public function setNumeroPrevia($NumeroPrevia)
    {
        $this->NumeroPrevia = $NumeroPrevia;
        return $this;
    }

    /**
     * @ignore
     */
    public function getFechaAprobadaPrevia()
    {
        return $this->FechaAprobadaPrevia;
    }

    /**
     * @ignore
     */
    public function setFechaAprobadaPrevia(\DateTime $FechaAprobadaPrevia)
    {
        $this->FechaAprobadaPrevia = $FechaAprobadaPrevia;
        return $this;
    }
}

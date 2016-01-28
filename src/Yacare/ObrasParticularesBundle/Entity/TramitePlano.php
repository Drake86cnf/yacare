<?php
namespace Yacare\ObrasParticularesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Yacare\TramitesBundle\Entity\Tramite;
use Symfony\Component\HttpFoundation\Tests\StringableObject;
use Symfony\Component\Config\Definition\IntegerNode;
use Symfony\Component\Config\Definition\FloatNode;

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
     * Superficie de la obra.
     *
     * @var float
     *
     * @ORM\Column(type="integer", nullable=false)
     *
     */
    private $ObraSuperficie;
    
    /**
     * El o los tipos del plano declarado por ejemplo (Obra nueva y ampliación)
     * 
     * @var integer
     * 
     * @ORM\Column(type ="integer", nullable=true)
     * 
     */
    private $PlanoTipo;
    
    /**
     * La superficie proyectada del plano
     * 
     * @var float
     * 
     * @ORM\Column(type="float", nullable=true)
     * 
     */
    private $SuperficieProyectada;
    
    /**
     * La superficie aprobada del plano
     *
     * @var float
     *
     * @ORM\Column(type="float", nullable=true)
     *
     */
    private $SuperficieAprobada;
    
    /**
     * La superficie relevada del plano
     *
     * @var float
     *
     * @ORM\Column(type="float", nullable=true)
     *
     */
    private $SuperficieRelevada;

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
 
}

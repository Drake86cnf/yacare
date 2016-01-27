<?php
namespace Yacare\ObrasParticularesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Yacare\TramitesBundle\Entity\Tramite;

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
     * @ORM\OneToMany(targetEntity="Yacare\ObrasParticularesBundle\Entity\ObraDestino")
     * @ORM\JoinTable(name="ObrasParticulares_TramitePlano_ObraDestino")
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
}

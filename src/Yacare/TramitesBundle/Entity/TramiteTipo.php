<?php

namespace Yacare\TramitesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yacare\TramitesBundle\Entity\TramiteTipo
 *
 * @ORM\Entity(repositoryClass="Yacare\BaseBundle\Entity\YacareBaseRepository")
 * @ORM\Table(name="Tramites_TramiteTipo")
 */
class TramiteTipo
{
    use \Yacare\BaseBundle\Entity\ConId;
    use \Yacare\BaseBundle\Entity\ConNombre;
    use \Yacare\BaseBundle\Entity\ConObs;
    use \Yacare\BaseBundle\Entity\ConUrl;
    use \Yacare\BaseBundle\Entity\Versionable;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Clase;
    
    /**
     * @ORM\ManyToOne(targetEntity="ComprobanteTipo")
     * @ORM\JoinColumn(nullable=true)
     */
    protected $ComprobanteTipo;
    
    /**
     * @ORM\ManyToOne(targetEntity="Instrumento")
     * @ORM\JoinColumn(nullable=true)
     */
    protected $Formulario;
    
    /**
     * Al crear o editar un tipo de trámite, se crea o edita un requisito que lo refleja.
     * @ORM\ManyToOne(targetEntity="Requisito", cascade={ "persist" })
     * @ORM\JoinColumn(nullable=true)
     */
    protected $RequisitoEspejo;
    
    /**
     * @ORM\OneToMany(targetEntity="AsociacionRequisito", mappedBy="TramiteTipo")
     * @ORM\JoinTable(name="Tramites_TramiteTipo_Requisito",
     *      joinColumns={@ORM\JoinColumn(name="TramiteTipo_id", referencedColumnName="id")}
     * )
     */
    private $AsociacionRequisitos;
    
    
    public function getClase() {
        return $this->Clase;
    }

    public function setClase($Clase) {
        $this->Clase = $Clase;
    }
    
    public function getFormulario() {
        return $this->Formulario;
    }

    public function setFormulario($Formulario) {
        $this->Formulario = $Formulario;
    }
    
    public function getAsociacionRequisitos() {
        return $this->AsociacionRequisitos;
    }

    public function setAsociacionRequisitos($AsociacionRequisitos) {
        $this->AsociacionRequisitos = $AsociacionRequisitos;
    }
    
    public function getRequisitoEspejo() {
        return $this->RequisitoEspejo;
    }

    public function setRequisitoEspejo($RequisitoEspejo) {
        $this->RequisitoEspejo = $RequisitoEspejo;
    }
    
    public function getComprobanteTipo() {
        return $this->ComprobanteTipo;
    }

    public function setComprobanteTipo($ComprobanteTipo) {
        $this->ComprobanteTipo = $ComprobanteTipo;
    }
}

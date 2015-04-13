<?php
namespace Yacare\TramitesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tipo de trámite (representa una especie).
 *
 * Define los datos de un trámite y está asociado a uno o más requisitos.
 *
 * ¡Atención! No define una instancia de un trámite, sino una especie. Esto es,
 * no representa un trámite en curso, sino que define cómo "se hace" un trámite.
 *
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 * @ORM\Table(name="Tramites_TramiteTipo")
 */
class TramiteTipo
{
    use \Tapir\BaseBundle\Entity\ConId;
    use \Tapir\BaseBundle\Entity\ConNombre;
    use \Tapir\BaseBundle\Entity\ConObs;
    use \Tapir\BaseBundle\Entity\ConNotas;
    use \Tapir\BaseBundle\Entity\ConUrl;
    use \Tapir\BaseBundle\Entity\Versionable;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;

    /**
     * El nombre de la clase (derivada de Tramite) con la cual instanciar los
     * trámites de este tipo.
     *
     * @var string @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Clase;

    /**
     * El tipo de comprobante que se emite al finalizar un trámite de este tipo.
     *
     * @ORM\ManyToOne(targetEntity="ComprobanteTipo")
     * @ORM\JoinColumn(nullable=true)
     */
    protected $ComprobanteTipo;

    /**
     * El formulario con el cual se inicia este trámite.
     *
     * @ORM\ManyToOne(targetEntity="Instrumento")
     * @ORM\JoinColumn(nullable=true)
     */
    protected $Formulario;

    /**
     * Requisito hermanado a este tipo de trámite.
     *
     * Al crear o editar un tipo de trámite, se crea o actualiza un requisito
     * que lo refleja para poder usarlo como requisito en otros tipos de trámite.
     *
     * @ORM\ManyToOne(targetEntity="Requisito", cascade={ "persist" })
     * @ORM\JoinColumn(nullable=true)
     */
    protected $RequisitoEspejo;

    /**
     * Requisitos asociados.
     *
     * Los tipos de trámite deber requerir que se cumplan uno o más requisitos
     * para completarse.
     *
     * @ORM\OneToMany(targetEntity="AsociacionRequisito", mappedBy="TramiteTipo")
     * @ORM\JoinTable(name="Tramites_TramiteTipo_Requisito",
     * joinColumns={@ORM\JoinColumn(name="TramiteTipo_id", referencedColumnName="id")}
     * )
     */
    private $AsociacionRequisitos;

    public function getClase()
    {
        return $this->Clase;
    }

    public function setClase($Clase)
    {
        $this->Clase = $Clase;
    }

    public function getFormulario()
    {
        return $this->Formulario;
    }

    public function setFormulario($Formulario)
    {
        $this->Formulario = $Formulario;
    }

    public function getAsociacionRequisitos()
    {
        return $this->AsociacionRequisitos;
    }

    public function setAsociacionRequisitos($AsociacionRequisitos)
    {
        $this->AsociacionRequisitos = $AsociacionRequisitos;
    }

    public function getRequisitoEspejo()
    {
        return $this->RequisitoEspejo;
    }

    public function setRequisitoEspejo($RequisitoEspejo)
    {
        $this->RequisitoEspejo = $RequisitoEspejo;
    }

    public function getComprobanteTipo()
    {
        return $this->ComprobanteTipo;
    }

    public function setComprobanteTipo($ComprobanteTipo)
    {
        $this->ComprobanteTipo = $ComprobanteTipo;
    }
}

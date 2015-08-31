<?php
namespace Yacare\TramitesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Requisito.
 *
 * Representa un requisito que se puede asociar a un trámite.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 *
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 * @ORM\Table(name="Tramites_Requisito")
 */
class Requisito
{
    use \Tapir\BaseBundle\Entity\ConId;
    use \Tapir\BaseBundle\Entity\ConNombre;
    use \Tapir\BaseBundle\Entity\ConObs;
    use \Tapir\BaseBundle\Entity\Versionable;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;

    public function __construct()
    {
        $this->Requiere = new \Doctrine\Common\Collections\ArrayCollection();
        $this->MeRequieren = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Requisitos de nivel superior.
     * 
     * @var \Yacare\TramitesBundle\Entity\Requisito
     * 
     * @see $Requiere $Requiere 
     * 
     * @ORM\ManyToMany(targetEntity="Requisito", mappedBy="Requiere")
     */
    private $MeRequieren;
    
    /**
     * Sub-requisitos.
     *
     * Si es un requisito "compuesto Y" o "compuesto O", estos son los requisitos
     * que lo componen.
     * 
     * @var \Yacare\TramitesBundle\Entity\Requisito
     * 
     * @see $Tipo $Tipo
     * 
     * @ORM\ManyToMany(targetEntity="Requisito", inversedBy="MeRequieren")
     * @ORM\JoinTable(name="Tramites_Requisito_Requisito", 
     *     joinColumns={@ORM\JoinColumn(name="MeRequiere_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="Requiere_id", referencedColumnName="id")}
     * )
     */
    private $Requiere;
    
    /**
     * El tipo de requisito.
     *
     * @var string
     * 
     * @see getTipoNombre() getTipoNombre()
     * 
     * @ORM\Column(type="string", length=50)
     */
    private $Tipo;
    
    /**
     * El lugar donde se obtiene o tramita este requisito.
     *
     * @var string 
     * 
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Lugar;
    
    /**
     * La dirección web donde se obtiene información sobre este requisito.
     *
     * @var string 
     * 
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Url;
    
    /**
     * Tipo de trámite hermanado con este requisito.
     *
     * Al crear o editar un tipo de trámite, se crea o edita un requisito que lo
     * refleja para que un trámite pueda ser requisito de otro.
     * 
     * @var \Yacare\TramitesBundle\Entity\TramiteTipo
     *
     * @ORM\ManyToOne(targetEntity="TramiteTipo")
     * @ORM\JoinColumn(nullable=true)
     */
    protected $TramiteTipoEspejo;

    /**
     * Devuelve el nomre normalizado del tipo de requisito.
     * 
     * @return string
     */
    public function getTipoNombre()
    {
        switch ($this->getTipo()) {
            case 'compy':
                return 'Compuesto Y';
            case 'compo':
                return 'Compuesto O';
            case 'cond':
                return 'Condición';
            case 'int':
                return 'Interno';
            case 'ext':
                return 'Externo';
            case 'tra':
                return 'Trámite';
        }
    }

    /**
     * @ignore
     */
    public function getTipo()
    {
        return $this->Tipo;
    }

    /**
     * @ignore
     */
    public function setTipo($Tipo)
    {
        $this->Tipo = $Tipo;
    }

    /**
     * @ignore
     */
    public function getLugar()
    {
        return $this->Lugar;
    }

    /**
     * @ignore
     */
    public function setLugar($Lugar)
    {
        $this->Lugar = $Lugar;
    }

    /**
     * @ignore
     */
    public function getUrl()
    {
        return $this->Url;
    }

    /**
     * @ignore
     */
    public function setUrl($Url)
    {
        $this->Url = $Url;
    }

    /**
     * @ignore
     */
    public function getRequiere()
    {
        return $this->Requiere;
    }

    /**
     * @ignore
     */
    public function setRequiere($Requiere)
    {
        $this->Requiere = $Requiere;
    }

    /**
     * @ignore
     */
    public function getMeRequieren()
    {
        return $this->MeRequieren;
    }

    /**
     * @ignore
     */
    public function setMeRequieren($MeRequieren)
    {
        $this->MeRequieren = $MeRequieren;
    }

    /**
     * @ignore
     */
    public function getTramiteTipoEspejo()
    {
        return $this->TramiteTipoEspejo;
    }

    /**
     * @ignore
     */
    public function setTramiteTipoEspejo($TramiteTipoEspejo)
    {
        $this->TramiteTipoEspejo = $TramiteTipoEspejo;
    }
}

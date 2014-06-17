<?php

namespace Yacare\TramitesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yacare\TramitesBundle\Entity\Requisito
 *
 * @ORM\Table(name="Tramites_Requisito")
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
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
     * @ORM\ManyToMany(targetEntity="Requisito", mappedBy="Requiere")
     */
    private $MeRequieren;
    
    /**
     * @ORM\ManyToMany(targetEntity="Requisito", inversedBy="MeRequieren")
     * @ORM\JoinTable(name="Tramites_Requisito_Requisito",
     *      joinColumns={@ORM\JoinColumn(name="MeRequiere_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="Requiere_id", referencedColumnName="id")}
     *      )
     **/
    private $Requiere;
    
    
    /**
     * @var string
     * @ORM\Column(type="string", length=50)
     */
    private $Tipo;
    
    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Lugar;
    
    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Url;
    
    /**
     * Al crear o editar un tipo de trámite, se crea o edita un requisito que lo refleja.
     * @ORM\ManyToOne(targetEntity="TramiteTipo")
     * @ORM\JoinColumn(nullable=true)
     */
    protected $TramiteTipoEspejo;
    
    
    public function getTipoNombre() {
        switch($this->getTipo()) {
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
    
    
    public function getTipo() {
        return $this->Tipo;
    }

    public function setTipo($Tipo) {
        $this->Tipo = $Tipo;
    }
    
    public function getLugar() {
        return $this->Lugar;
    }

    public function setLugar($Lugar) {
        $this->Lugar = $Lugar;
    }

    public function getUrl() {
        return $this->Url;
    }

    public function setUrl($Url) {
        $this->Url = $Url;
    }
    
    public function getRequiere() {
        return $this->Requiere;
    }

    public function setRequiere($Requiere) {
        $this->Requiere = $Requiere;
    }

    public function getMeRequieren() {
        return $this->MeRequieren;
    }

    public function setMeRequieren($MeRequieren) {
        $this->MeRequieren = $MeRequieren;
    }
    
    public function getTramiteTipoEspejo() {
        return $this->TramiteTipoEspejo;
    }

    public function setTramiteTipoEspejo($TramiteTipoEspejo) {
        $this->TramiteTipoEspejo = $TramiteTipoEspejo;
    }
}

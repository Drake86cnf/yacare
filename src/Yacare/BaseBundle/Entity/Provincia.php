<?php
namespace Yacare\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Describe una provincia o estado.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 *
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 * @ORM\Table(name="Base_Provincia")
 */
class Provincia
{
    use \Tapir\BaseBundle\Entity\ConId;
    use \Tapir\BaseBundle\Entity\ConNombre;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
    use \Tapir\BaseBundle\Entity\Versionable;

    /**
     * El código de 3 letras que identifica a esta provincia o estado (Argentina), según el Instituto Federal de Asuntos
     * Municipales.
     *
     * @var string
     *
     * @ORM\Column(type="string", length=3)
     */
    private $CodigoIfam;

    /**
     * El código ISO 3166-2 que identifica a esta provincia o estado.
     *
     * http://en.wikipedia.org/wiki/ISO_3166-2
     *
     * @var string
     *
     * @ORM\Column(type="string", length=4)
     */
    private $CodigoIso;

    /**
     * El nombre oficial o diplomático, si fuera diferente del nombre común.
     *
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $NombreOficial;

    /**
     * Uno o más gentilicios admitidos, en masculino singular, separados por coma.
     *
     * @var string
     * @see GentiliciosFemeninos
     *
     * @ORM\Column(type="string", length=255)
     */
    private $GentiliciosMasculinos;

    /**
     * Uno o más gentilicios admitidos, en femenino singular, separados por coma.
     *
     * @var string
     * @see GentiliciosMasculinos
     *
     * @ORM\Column(type="string", length=255)
     */
    private $GentiliciosFemeninos;

    /**
     * El país al cual pertenece esta provincia o estado. El predeterminado es Argentina.
     *
     * @var Pais
     *
     * @see \Yacare\BaseBundle\Entity\Pais Pais
     *
     * @ORM\ManyToOne(targetEntity="Pais")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $Pais = 9;

    /**
     * Dirección de la página oficial
     *
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $Url;



    /**
     * @ignore
     */
    public function getNombreOficial()
    {
        return $this->NombreOficial;
    }

    /**
     * @ignore
     */
    public function setNombreOficial($NombreOficial)
    {
        $this->NombreOficial = $NombreOficial;
        return $this;
    }

    /**
     * @ignore
     */
    public function getPais()
    {
        return $this->Pais;
    }

    /**
     * @ignore
     */
    public function setPais($Pais)
    {
        $this->Pais = $Pais;
        return $this;
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
        return $this;
    }

    /**
     * @ignore
     */
    public function getCodigoIfam()
    {
        return $this->CodigoIfam;
    }

    /**
     * @ignore
     */
    public function setCodigoIfam($CodigoIfam)
    {
        $this->CodigoIfam = $CodigoIfam;
        return $this;
    }

    /**
     * @ignore
     */
    public function getCodigoIso()
    {
        return $this->CodigoIso;
    }

    /**
     * @ignore
     */
    public function setCodigoIso($CodigoIso)
    {
        $this->CodigoIso = $CodigoIso;
        return $this;
    }

    /**
     * @ignore
     */
    public function getGentiliciosMasculinos()
    {
        return $this->GentiliciosMasculinos;
    }

    /**
     * @ignore
     */
    public function setGentiliciosMasculinos($GentiliciosMasculinos)
    {
        $this->GentiliciosMasculinos = $GentiliciosMasculinos;
        return $this;
    }

    /**
     * @ignore
     */
    public function getGentiliciosFemeninos()
    {
        return $this->GentiliciosFemeninos;
    }

    /**
     * @ignore
     */
    public function setGentiliciosFemeninos($GentiliciosFemeninos)
    {
        $this->GentiliciosFemeninos = $GentiliciosFemeninos;
        return $this;
    }

}

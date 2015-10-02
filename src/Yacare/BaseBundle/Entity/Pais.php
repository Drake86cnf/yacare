<?php
namespace Yacare\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Describe un país.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 *
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 * @ORM\Table(name="Base_Pais")
 */
class Pais
{
    use \Tapir\BaseBundle\Entity\ConId;
    use \Tapir\BaseBundle\Entity\ConNombre;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
    use \Tapir\BaseBundle\Entity\Versionable;

    /**
     * El código ISO 3166-1 Alfa-2 del país.
     *
     * http://en.wikipedia.org/wiki/ISO_3166-1_alpha-2
     *
     * @var string
     *
     * @ORM\Column(type="string", length=2)
     */
    private $IsoAlfa2;

    /**
     * El dominio de nivel superior geográfico.
     *
     * https://en.wikipedia.org/wiki/List_of_Internet_top-level_domains#Country_code_top-level_domains
     *
     * @var string
     *
     * @ORM\Column(type="string", length=3)
     */
    private $Cctld;

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
     * El código ISO de la moneda principal del país.
     *
     * http://en.wikipedia.org/wiki/ISO_4217
     *
     * @var string
     *
     * @ORM\Column(type="string", length=3)
     */
    private $MonedaIso;

    /**
     * El nombre oficial o diplomático en castellano (por ejemplo "República Argentina" en lugar de "Argentina"), según
     * el país mismo, la ONU o en su defecto otra fuente como la RAE. Puede estar el blanco si el nombre común es el
     * mismo que el oficial (por ejemplo Canadá o Hungría).
     *
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $NombreOficial;

    /**
     * El nombre en inglés.
     *
     * @var string
     * @see $Nombre
     *
     * @ORM\Column(type="string", length=255)
     */
    private $NombreIngles;

    /**
     * El nombre oficial en inglés.
     *
     * @var string
     * @see $NombreOficial
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $NombreOficialIngles;



    /**
     * @ignore
     */
    public function getIsoAlfa2()
    {
        return $this->IsoAlfa2;
    }

    /**
     * @ignore
     */
    public function setIsoAlfa2(string $IsoAlfa2)
    {
        $this->IsoAlfa2 = $IsoAlfa2;
        return $this;
    }

    /**
     * @ignore
     */
    public function getCctld()
    {
        return $this->Cctld;
    }

    /**
     * @ignore
     */
    public function setCctld(string $Cctld)
    {
        $this->Cctld = $Cctld;
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

    /**
     * @ignore
     */
    public function getMonedaIso()
    {
        return $this->MonedaIso;
    }

    /**
     * @ignore
     */
    public function setMonedaIso(string $MonedaIso)
    {
        $this->MonedaIso = $MonedaIso;
        return $this;
    }

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
    public function setNombreOficial(string $NombreOficial)
    {
        $this->NombreOficial = $NombreOficial;
        return $this;
    }

    /**
     * @ignore
     */
    public function getNombreIngles()
    {
        return $this->NombreIngles;
    }

    /**
     * @ignore
     */
    public function setNombreIngles($NombreIngles)
    {
        $this->NombreIngles = $NombreIngles;
        return $this;
    }

    /**
     * @ignore
     */
    public function getNombreOficialIngles()
    {
        return $this->NombreOficialIngles;
    }

    /**
     * @ignore
     */
    public function setNombreOficialIngles($NombreOficialIngles)
    {
        $this->NombreOficialIngles = $NombreOficialIngles;
        return $this;
    }
}

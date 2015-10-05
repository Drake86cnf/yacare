<?php
namespace Yacare\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Describe una localidad (ciudad, municipio, pueblo, comuna, etc.)
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 *
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 * @ORM\Table(name="Base_Localidad")
 */
class Localidad
{
    use \Tapir\BaseBundle\Entity\ConId;
    use \Tapir\BaseBundle\Entity\ConNombre;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
    use \Tapir\BaseBundle\Entity\Versionable;

    /**
     * El código de 3 letras que identifica a este municipio (Argentina), según el Instituto Federal de Asuntos
     * Municipales.
     *
     * @var string
     *
     * @ORM\Column(type="string", length=6)
     */
    private $CodigoIfam;

    /**
     * El país al cual pertenece esta localidad. El predeterminado es Argentina.
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
     * La provincia a la cual pertenece esta localidad.
     *
     * @var Pais
     *
     * @see \Yacare\BaseBundle\Entity\Pais Pais
     *
     * @ORM\ManyToOne(targetEntity="Provincia")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $Provincia;

    /**
     * Dirección de la página oficial
     *
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $Url;


    /**
     * Coordenadas de su ubicación.
     *
     * @var \Point
     *
     * @ORM\Column(type="point", nullable=true)
     */
    protected $Ubicacion;


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
    public function getProvincia()
    {
        return $this->Provincia;
    }

    /**
     * @ignore
     */
    public function setProvincia($Provincia)
    {
        $this->Provincia = $Provincia;
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
    public function getUbicacion()
    {
        return $this->Ubicacion;
    }

    /**
     * @ignore
     */
    public function setUbicacion(\Point $Ubicacion)
    {
        $this->Ubicacion = $Ubicacion;
        return $this;
    }

}

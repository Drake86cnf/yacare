<?php
namespace Yacare\ComercioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Representa un trámite de habilitacion comercial.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 *
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 * @ORM\Table(name="Comercio_TramiteHabilitacionComercial")
 */
class TramiteHabilitacionComercial extends \Yacare\TramitesBundle\Entity\Tramite
    implements ITramiteHabilitacionComercial
{
    use \Yacare\TramitesBundle\Entity\ConApoderado;

    public function __construct()
    {
        parent::__construct();
        $this->Nombre = 'Habilitación comercial';
    }

    /**
     * El comercio.
     *
     * @var Comercio
     *
     * @ORM\ManyToOne(targetEntity="Yacare\ComercioBundle\Entity\Comercio", cascade={"persist"})
     * @ORM\JoinColumn(referencedColumnName="id", nullable=false)
     */
    protected $Comercio;

    /**
     * Almacena el valor de uso de suelo para la partida en la cual se encuentra el local, para la actividad
     * seleccionada.
     *
     * @var string
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $UsoSuelo = null;

    /**
     * Devuelve el nombre de UsoSuelo normalizado.
     *
     * @return string
     */
    public function UsoSueloNombre()
    {
        return \Yacare\CatastroBundle\Entity\UsoSuelo::UsoSueloNombre($this->getUsoSuelo());
    }
    
    /**
     * Devuelve un colección de los actores que intervienen en este trámite, y el nombre de la propiedad
     * que refleja a cada uno.
     */
    public function Actores() {
        $res = parent::Actores();
        return array_merge($res, array(
            'Apoderado' => 'Apoderado',
            'Comercio' => 'Comercio',
            'Local' => 'Local comercial'
        ));
    }

    /**
     * Devuelve true si el trámite está listo para ser terminado (es decir,
     * todos los requisitos están cumplidos).
     *
     * @return boolean
     *
     * @see \Yacare\TramitesBundle\Entity\Tramite::EstaListoParaTerminar() Tramite::EstaListoParaTerminar()
     */
    public function EstaListoParaTerminar()
    {
        return $this->getUsoSuelo() <= 4 && parent::EstaListoParaTerminar();
    }
    
    
    /**
     * Devuelve una lista de razones por las que no se puede terminar.
     * @return string[] La lista.
     */
    public function QueImpideTerminar() {
        $res = parent::QueImpideTerminar();
        if($this->getUsoSuelo() > 4) {
            $res[] = 'El uso de suelo no es admisible.';
        }
        
        return $res;
    }

    /**
     * @ignore
     */
    public function getInmueble()
    {
        return $this->getComercio()->getInmueble();
    }

    /**
     * @ignore
     */
    public function getLocal()
    {
        return $this->getComercio()->getLocal();
    }

    /**
     * @ignore
     */
    public function getRequiereDeyma()
    {
        return $this->getComercio()->getRequiereDeyma();
    }

    /**
     * @ignore
     */
    public function getRequiereDbeh()
    {
        return $this->getComercio()->getRequiereDbeh();
    }

    /**
     * @ignore
     */
    public function getRequiereCamaraBarro()
    {
        return $this->getComercio()->getRequiereCamaraBarro();
    }

    /**
     * @ignore
     */
    public function getRequiereCamaraGrasa()
    {
        return $this->getComercio()->getRequiereCamaraGrasa();
    }

    /**
     * @ignore
     */
    public function getRequiereImpactoSonoro()
    {
        return $this->getComercio()->getRequiereImpactoSonoro();
    }

    /**
     * @ignore
     */
    public function getRequiereFactorOcupacion()
    {
        return $this->getComercio()->getRequiereFactorOcupacion();
    }

    /**
     * @ignore
     */
    public function getRequiereInfEscolar()
    {
        return $this->getComercio()->getRequiereInfEscolar();
    }

    /**
     * @ignore
     */
    public function getUsoSuelo()
    {
        return $this->UsoSuelo;
    }

    /**
     * @ignore
     */
    public function setUsoSuelo($UsoSuelo)
    {
        $this->UsoSuelo = $UsoSuelo;
    }

    /**
     * @ignore
     */
    public function getComercio()
    {
        return $this->Comercio;
    }

    /**
     * @ignore
     */
    public function setComercio($Comercio)
    {
        $this->Comercio = $Comercio;
    }
}

<?php
namespace Yacare\RecursosHumanosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Representa la antigüedad de un agente.
 *
 * @author Ezequiel Riquelme <rezequiel.tdf@gmail.com>
 * 
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 * @ORM\Table(name="Rrhh_Antiguedad")
 */
class AgenteAntiguedad
{
    use \Tapir\BaseBundle\Entity\ConId;
    
    /**
     * Establece el "desde" en el rango de fecha.
     * 
     * @var \Date
     *
     * @ORM\Column(type="date", nullable=false)
     * @Assert\Date(message="Por favor proporcione una fecha 'desde'.")
     */
    private $Desde;
    
    /**
     * Establece el "hasta" en el rango de fecha.
     * 
     * @var \Date
     *
     * @ORM\Column(type="date", nullable=false)
     * @Assert\Date(message="Por favor proporcione una fecha 'hasta'.")
     */
    private $Hasta;
    
    /**
     * El tipo de antigüedad.
     * 
     * @var integer
     *
     * @ORM\Column(type="smallint", nullable=false)
     */
    private $Tipo;
    
    /**
     * ???
     * 
     * @var boolean
     *
     * @ORM\Column(type="boolean")
     */
    private $Reparticion;
    
    /**
     * ???
     * 
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    private $PresentarReparticion;
    
    /**
     * ???
     * 
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    private $ReconoceAnses;

    /**
     * Obtiene el nombre del tipo de antigüedad.
     *
     * @return string
     *
     * @see $TipoNombre $TipoNombre
     */
    public function getTipoNombre()
    {
        return AgenteAntiguedad::setTiposNombres($this->getTipoNombre());
    }

    /**
     * Normaliza nombres de tipos de antigüedad.
     * 
     * @return string
     * 
     * @see $Tipo $Tipo
     */
    public static function setTiposNombres($rango)
    {
        switch ($rango) {
            case 1:
                return 'Municipio RG';
            case 2:
                return 'Otros municipios';
            case 3:
                return 'Estado Nacional';
            case 4:
                return 'Privado';
            case 5:
                return 'Estado Provincial TDF';
            case 6:
                return 'Otros estados provinciales';
            case 7:
                return 'Autónomo';
            case 8:
                return 'Sin certificación';
            case 99:
                return 'Lic. sin goce de haberes';
            default:
                return '';
        }
    }

    /**
     * @ignore
     */
    public function getDesde()
    {
        return $this->Desde;
    }

    /**
     * @ignore
     */
    public function setDesde($Desde)
    {
        $this->Desde = $Desde;
        return $this;
    }

    /**
     * @ignore
     */
    public function getHasta()
    {
        return $this->Hasta;
    }

    /**
     * @ignore
     */
    public function setHasta($Hasta)
    {
        $this->Hasta = $Hasta;
        return $this;
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
        return $this;
    }

    /**
     * @ignore
     */
    public function getReparticion()
    {
        return $this->Reparticion;
    }

    /**
     * @ignore
     */
    public function setReparticion($Reparticion)
    {
        $this->Reparticion = $Reparticion;
        return $this;
    }

    /**
     * @ignore
     */
    public function getPresentarReparticion()
    {
        return $this->PresentarReparticion;
    }

    /**
     * @ignore
     */
    public function setPresentarReparticion($PresentarReparticion)
    {
        $this->PresentarReparticion = $PresentarReparticion;
        return $this;
    }

    /**
     * @ignore
     */
    public function getReconoceAnses()
    {
        return $this->ReconoceAnses;
    }

    /**
     * @ignore
     */
    public function setReconoceAnses($ReconoceAnses)
    {
        $this->ReconoceAnses = $ReconoceAnses;
        return $this;
    }
}

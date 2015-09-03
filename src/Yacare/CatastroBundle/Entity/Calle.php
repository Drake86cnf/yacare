<?php
namespace Yacare\CatastroBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Representa una calle.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 *
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 * @ORM\Table(name="Catastro_Calle", indexes={
 *     @ORM\Index(name="Catastro_Calle_Nombre", columns={"nombre"})
 * })
 */
class Calle
{
    use \Tapir\BaseBundle\Entity\ConId;
    use \Tapir\BaseBundle\Entity\ConNombre;
    use \Tapir\BaseBundle\Entity\Versionable;
    use \Tapir\BaseBundle\Entity\Importable;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
    
    /**
     * El nombre original.
     * 
     * @var string 
     * 
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $NombreOriginal;
    
    /**
     * El nombre alternativo.
     * 
     * @var string 
     * 
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $NombreAlternativo;
    
    /**
     * El tipo.
     * 
     * @var int 
     * 
     * @ORM\Column(type="integer", nullable=false)
     */
    private $Tipo;

    /**
     * Normaliza el tipo de calle.
     * 
     * @param  integer $tipo
     * @return string
     */
    public static function getTipoNombres($tipo)
    {
        switch ($tipo) {
            case 0:
                return 'Calle';
            case 1:
                return 'Avenida';
            case 2:
                return 'Bulevar';
            case 3:
                return 'Pasaje';
            default:
                return '';
        }
    }

    /**
     * Devuelve el tipo normalizado de calle.
     * 
     * @return string
     */
    public function getTipoNombre()
    {
        return self::getTipoNombres($this->getTipo());
    }

    /**
     * @ignore
     */
    public function getNombreOriginal()
    {
        return $this->NombreOriginal;
    }

    /**
     * @ignore
     */
    public function setNombreOriginal($NombreOriginal)
    {
        $this->NombreOriginal = $NombreOriginal;
        return $this;
    }

    /**
     * @ignore
     */
    public function getNombreAlternativo()
    {
        return $this->NombreAlternativo;
    }

    /**
     * @ignore
     */
    public function setNombreAlternativo($NombreAlternativo)
    {
        $this->NombreAlternativo = $NombreAlternativo;
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
}

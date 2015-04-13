<?php
namespace Yacare\CatastroBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yacare\CatastroBundle\Entity\Calle
 *
 * @ORM\Table(name="Catastro_Calle",
 * indexes={
 * @ORM\Index(name="Catastro_Calle_Nombre", columns={"nombre"})
 * })
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 */
class Calle
{
    use \Tapir\BaseBundle\Entity\ConId;
    use \Tapir\BaseBundle\Entity\ConNombre;
    use \Tapir\BaseBundle\Entity\Versionable;
    use \Tapir\BaseBundle\Entity\Importable;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;

    /**
     *
     * @var string @ORM\Column(type="string", length=255, nullable=true)
     */
    private $NombreOriginal;

    /**
     *
     * @var string @ORM\Column(type="string", length=255, nullable=true)
     */
    private $NombreAlternativo;

    /**
     *
     * @var int @ORM\Column(type="integer", nullable=false)
     */
    private $Tipo;

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

    public function getTipoNombre()
    {
        return Calle::getTipoNombres($this->getTipo());
    }

    public function getNombreOriginal()
    {
        return $this->NombreOriginal;
    }

    public function setNombreOriginal($NombreOriginal)
    {
        $this->NombreOriginal = $NombreOriginal;
        return $this;
    }

    public function getNombreAlternativo()
    {
        return $this->NombreAlternativo;
    }

    public function setNombreAlternativo($NombreAlternativo)
    {
        $this->NombreAlternativo = $NombreAlternativo;
        return $this;
    }

    public function getTipo()
    {
        return $this->Tipo;
    }

    public function setTipo($Tipo)
    {
        $this->Tipo = $Tipo;
        return $this;
    }
}

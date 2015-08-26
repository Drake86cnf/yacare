<?php
namespace Yacare\CatastroBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yacare\CatastroBundle\Entity\Zona
 *
 * @ORM\Table(name="Catastro_Zona", indexes={
 *     @ORM\Index(name="Catastro_Zona_Nombre", columns={"Nombre"})
 *     }
 * )
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 */
class Zona
{
    use \Tapir\BaseBundle\Entity\ConId;
    use \Tapir\BaseBundle\Entity\ConNombre;
    use \Tapir\BaseBundle\Entity\ConObs;
    use \Tapir\BaseBundle\Entity\Versionable;
    use \Tapir\BaseBundle\Entity\Importable;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
    
    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $Codigo;
    
    /** 
     * @ORM\Column(type="decimal", precision=14, scale=2, nullable=true)
     */
    private $Fos;
    
    /**
     * @ORM\Column(type="decimal", precision=14, scale=2, nullable=true)
     */
    private $Fot;

    /**
     * @ignore
     */
    public function getCodigo()
    {
        return $this->Codigo;
    }

    /**
     * @ignore
     */
    public function setCodigo($Codigo)
    {
        $this->Codigo = $Codigo;
    }

    /**
     * @ignore
     */
    public function getFos()
    {
        return $this->Fos;
    }

    /**
     * @ignore
     */
    public function getFot()
    {
        return $this->Fot;
    }

    /**
     * @ignore
     */
    public function setFos($Fos)
    {
        $this->Fos = $Fos;
    }

    /**
     * @ignore
     */
    public function setFot($Fot)
    {
        $this->Fot = $Fot;
    }
}

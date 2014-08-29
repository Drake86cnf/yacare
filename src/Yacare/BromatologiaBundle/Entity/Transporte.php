<?php
namespace Yacare\BromatologiaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yacare\BromatologiaBundle\Entity\Transporte
 *
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 * @ORM\Table(name="Bromatologia_Transporte")
 */
class Transporte
{
    use\Tapir\BaseBundle\Entity\ConId;
    use\Tapir\BaseBundle\Entity\ConNombre;
    use\Yacare\BaseBundle\Entity\ConDomicilio;
    use\Tapir\BaseBundle\Entity\Versionable;
    use\Tapir\BaseBundle\Entity\Suprimible;
    use\Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;

    /**
     * @ORM\ManyToOne(targetEntity="Yacare\BaseBundle\Entity\Persona")
     * @ORM\JoinColumn(nullable=true)
     * @ORM\OrderBy({ "NombreVisible" = "ASC" })
     */
    protected $Titular;

    /**
     * @ORM\ManyToOne(targetEntity="Yacare\ComercioBundle\Entity\CertificadoHabilitacionComercial")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    protected $Comercio;

    public function getTitular()
    {
        return $this->Titular;
    }

    public function setTitular($Titular)
    {
        $this->Titular = $Titular;
    }

    public function getComercio()
    {
        return $this->Comercio;
    }

    public function setComercio($Comercio)
    {
        $this->Comercio = $Comercio;
    }
}

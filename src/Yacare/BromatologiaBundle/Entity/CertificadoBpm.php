<?php
namespace Yacare\BromatologiaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yacare\BromatologiaBundle\Entity\CertificadoBpm
 *
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 * @ORM\Table(name="Bromatologia_CertificadoBpm")
 */
class CertificadoBpm
{
    use\Tapir\BaseBundle\Entity\ConId;
    use\Tapir\BaseBundle\Entity\Versionable;
    use\Tapir\BaseBundle\Entity\Suprimible;
    use\Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;

    /**
     * @ORM\ManyToOne(targetEntity="Yacare\BaseBundle\Entity\Persona")
     * @ORM\JoinColumn(nullable=true)
     * @ORM\OrderBy({ "NombreVisible" = "ASC" })
     */
    protected $Persona;

    /**
     *
     * @var \DateTime @ORM\Column(type="datetime")
     */
    private $FechaExamen;

    public function __toString()
    {
        return 'Certificado N° ' . $this->getId() . ' de ' . $this->getPersona()->getNombreVisible();
    }

    /**
     *
     * @var integer @ORM\Column(type="integer")
     */
    private $Nota;

    public function getPersona()
    {
        return $this->Persona;
    }

    public function setPersona($Persona)
    {
        $this->Persona = $Persona;
    }

    public function getFechaExamen()
    {
        return $this->FechaExamen;
    }

    public function setFechaExamen(\DateTime $FechaExamen)
    {
        $this->FechaExamen = $FechaExamen;
    }

    public function getNota()
    {
        return $this->Nota;
    }

    public function setNota($Nota)
    {
        $this->Nota = $Nota;
    }
}

<?php
namespace Yacare\ComercioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Representa un Certificado de factibilidad de uso de suelo.
 *
 * @author Alejandro Díaz <alediaz.rc@gmail.com>
 *
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 * @ORM\Table(name="Comercio_CertificadoUsoSuelo")
 */
class TramiteCertificadoUsoSuelo
{
    use \Tapir\BaseBundle\Entity\ConId;
    use \Tapir\BaseBundle\Entity\ConNombre;
    use \Tapir\BaseBundle\Entity\Versionable;
    use \Yacare\BaseBundle\Entity\ConFechaValidezHasta;
    use \Yacare\AdministracionBundle\Entity\ConActoAdministrativo;
    use \Yacare\ComercioBundle\Entity\ConActividades;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;

    /**
     * Indica la fecha en la que se emitio el certificado.
     *
     * @var \Date
     *
     * @ORM\Column(type="date", nullable=false)
     * @Assert\Date(message="Por favor proporcione una fecha de emisión.")
     */
    private $FechaEmision;

    /**
     * Indica el codigo de resolución condicionada.
     *
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $ResolucionCondicionada;

    /**
     * @ignore
     */
    public function getFechaEmision()
    {
        return $this->FechaEmision;
    }

    /**
     * @ignore
     */
    public function setFechaEmision($FechaEmision)
    {
        $this->FechaEmision = $FechaEmision;
        return $this;
    }

    /**
     * @ignore
     */
    public function getResolucionCondicionada()
    {
        return $this->ResolucionCondicionada;
    }

    /**
     * @ignore
     */
    public function setResolucionCondicionada($ResolucionCondicionada)
    {
        $this->ResolucionCondicionada = $ResolucionCondicionada;
        return $this;
    }
}

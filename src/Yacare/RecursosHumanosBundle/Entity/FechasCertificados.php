<?php
namespace Yacare\RecursosHumanosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Fechas de certificados varios, asociados a un agente.
 *
 * @author Ezequiel Riquelme <rezequiel.tdf@gmail.com>
 *        
 * @ORM\Table(name="Rrhh_FechasCertificados")
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 */
class FechasCertificados
{
    use \Tapir\BaseBundle\Entity\ConId;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
    use \Tapir\BaseBundle\Entity\Versionable;
    use \Tapir\BaseBundle\Entity\Suprimible;

    /**
     * La fecha de certificado de buena conducta.
     *
     * @ORM\Column(type="date", nullable=false)
     * @Assert\Type("\DateTime")
     */
    private $CertificadoBuenaConducta;

    /**
     * La fecha de certificado de antecedentes penales.
     *
     * @ORM\Column(type="date", nullable="false")
     * @Assert\Type("\DateTime")
     */
    private $CertificadoAntecedentesPenales;

    /**
     * La fecha de certificado de domicilio.
     *
     * @ORM\Column(type="date", nullable="true")
     * @Assert\Type("\DateTime")
     */
    private $CertificadoDomicilio;

    /**
     *
     * @ignore
     *
     */
    public function setCertificadoBuenaConducta($CertificadoBuenaConducta)
    {
        return $this->CertificadoBuenaConducta = $CertificadoBuenaConducta;
    }

    /**
     *
     * @ignore
     *
     */
    public function getCertificadoBuenaConducta()
    {
        return $this->CertificadoBuenaConducta;
    }

    /**
     *
     * @ignore
     *
     */
    public function setCertificadoAntecedentesPenales($CertificadoAntecedentesPenales)
    {
        return $this->CertificadoAntecedentesPenales = $CertificadoAntecedentesPenales;
    }

    /**
     *
     * @ignore
     *
     */
    public function getCertificadoAntecedentesPenales()
    {
        return $this->CertificadoAntecedentesPenales;
    }

    /**
     *
     * @ignore
     *
     */
    public function setCertificadoDomicilio($CertificadoDomicilio)
    {
        return $this->CertificadoDomicilio = $CertificadoDomicilio;
    }

    /**
     *
     * @ignore
     *
     */
    public function getCertificadoDomicilio()
    {
        return $this->CertificadoDomicilio;
    }
}
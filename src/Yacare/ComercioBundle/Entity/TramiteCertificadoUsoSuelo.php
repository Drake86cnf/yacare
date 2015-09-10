<?php
namespace Yacare\ComercioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Representa un Certificado de factibilidad de uso de suelo.
 * 
 * @author Diaz Alejandro <alediaz.rc@gmail.com>
 *
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 * @ORM\Table(name="Comercio_CertificadoUsoSuelo")
 */
class TramiteCertificadoUsoSuelo
{
    use \Tapir\BaseBundle\Entity\ConId;
    use \Tapir\BaseBundle\Entity\ConNombre;
    use \Tapir\BaseBundle\Entity\Versionable;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
    use \Yacare\Comercio\Entity\ConActividades;
    use \Yacare\AdministracionBundle\Entity\ConActoAdministrativo;
    
    /**
     * Indica la fecha en la que se emitio el certificado.
     * 
     * @var \DateTime
     * 
     * @ORM\Column(type="date", nullable=false)
     * @Assert\Type("\DateTime")
     * 
     */
    private $FechaEmision;
    
    /**
     * Indica la fecha de vencimiento de el certificado.
     *
     * @var \DateTime
     *
     * @ORM\Column(type="date", nullable=false)
     * @Assert\Type("\DateTime")
     *
     */
    private $FechaVencimiento;
    
    /**
     * Indica el codigo de resolución condicionada.
     * 
     * @var string
     * 
     * @ORM\Column(type="string", nullable=true)
     * 
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
    public function setFechaEmision(\DateTime $FechaEmision)
    {
        $this->FechaEmision = $FechaEmision;
        return $this;
    }

    /**
     * @ignore
     */
    public function getFechaVencimiento()
    {
        return $this->FechaVencimiento;
    }

    /**
     * @ignore
     */
    public function setFechaVencimiento(\DateTime $FechaVencimiento)
    {
        $this->FechaVencimiento = $FechaVencimiento;
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

    


<?php
namespace Yacare\ComercioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * El comercio.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 *
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 * @ORM\Table(name="Comercio_Comercio")
 */
class Comercio implements IComercio
{
    use \Tapir\BaseBundle\Entity\ConId;
    use \Tapir\BaseBundle\Entity\ConNombre;
    use \Tapir\BaseBundle\Entity\ConObs;
    use \Yacare\ComercioBundle\Entity\ConDatosComercio;
    use \Yacare\AdministracionBundle\Entity\ConExpediente;
    use \Yacare\AdministracionBundle\Entity\ConActoAdministrativo;
    use \Tapir\BaseBundle\Entity\Suprimible;
    use \Tapir\BaseBundle\Entity\Versionable;
    use \Yacare\BaseBundle\Entity\ConRequiereAtencion;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
    use \Yacare\TramitesBundle\Entity\ConTitular;
    use \Yacare\TramitesBundle\Entity\ConApoderado;
    
    public function __construct()
    {
        $this->Actas = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * El domicilio declarado, que puede ser diferente al domicilio catastral del local comercial.
     * 
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $Domicilio = null;
    
    /**
     * La posición en archivo. Es una nomenclatura que utiliza comercio para ubicar el expediente físico.
     * 
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $PosicionArchivo = null;
    
    /**
     * La fecha de la habilitación o null si aun no está habilitado.
     * 
     * @ORM\Column(type="date", nullable=true)
     * @Assert\Date(message="Por favor proporcione una fecha de habilitación válida.")
     */
    protected $FechaHabilitacion = null;
    
    /**
     * El número de acto administrativo asociado a baja, en el formato DM-1234/2015.
     *
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Regex(
     *     pattern="/^\s*(\w{1,4})([ |\-])*(\d{1,5})\/(19|20)(\d{2})\s*$/i",
     *     message="Debe escribir el número de acto administrativo en el formato DM-1234/2015, RC-321/2014, etc."
     * )
     */
    protected $ActoAdministrativoBajaNumero;
    
    /**
     * La fecha de baja, o null si el comercio todavía está habilitado.
     * 
     * @ORM\Column(type="date", nullable=true)
     * @Assert\Date(message="Por favor proporcione una fecha de baja válida.")
     */
    protected $FechaBaja;
    
    /**
     * La fecha de la última acta.
     * 
     * @ORM\Column(type="date", nullable=true)
     */
    protected $FechaUltimaActa;
    
    /**
     * El estado de comercio (habilitado, en trámite, no habilitado).
     * 
     * @var integer
     * 
     * @ORM\Column(type="integer")
     */
    protected $Estado = 0;
    
    /**
     * El último certificado de habilitación emitido para este comercio.
     * 
     * @var CertificadoHabilitacionComercial
     * 
     * @ORM\ManyToOne(targetEntity="Yacare\ComercioBundle\Entity\CertificadoHabilitacionComercial")
     * @ORM\JoinColumn(nullable=true)
     */
    protected $CertificadoHabilitacion;
    
    /**
     * Las actas asociadas a este comercio.
     *
     * @var ActaComercio
     *
     * @ORM\OneToMany(targetEntity="ActaComercio", mappedBy="Comercio")
     *
     * @JMS\Serializer\Annotation\Exclude
     */
    protected $Actas;
    
    /**
     * Setter con sanitización.
     */
    public function setActoAdministrativoBajaNumero($actoAdministrativoBajaNumero)
    {
        $this->ActoAdministrativoBajaNumero = SanitizarActoAdministrativo($actoAdministrativoBajaNumero);
        return $this;
    }
    
    /**
     * Setter con sanitización.
     */
    public function setPosicionArchivo($PosicionArchivo)
    {
        if($PosicionArchivo) {
            $PosicionArchivo = strtoupper(trim($PosicionArchivo, "-. \t\n\r\0\x0B"));
            
            $Letra = substr($PosicionArchivo, 0, 1);
            $Numero = (int)substr($PosicionArchivo, 1);
            if($Numero > 0) {
                $PosicionArchivo = $Letra . str_pad($Numero, 3, '0', STR_PAD_LEFT);
            }
        }
        $this->PosicionArchivo = $PosicionArchivo;
        
        return $this;
    }
    
    /**
     * Devuelve el domicilio declarado, en caso de que tenga uno o el domicilio catastral en caso de que tenga un local.
     */
    public function getDomicilioReal() {
        
        if($this->Domicilio) {
            return $this->Domicilio;
        } elseif($this->getLocal() && $this->getLocal()->getPartida()) {
            return $this->getLocal()->getPartida()->getDomicilio();
        } else {
            return '';
        }
    }

    /**
     * Devuelve nombres de estado normalizados.
     * 
     * @param  integer $estado
     * @return string
     */
    public static function NombreEstado($estado)
    {
        switch ($estado) {
            case 0:
                return 'No habilitado';
            case 1:
                return 'En trámite';
            case 90:
                return 'Hab., sin actividad';
            case 91:
                return 'Hab. vencida';
            case 100:
                return 'Habilitado';
            default:
                return '???';
        }
    }

    /**
     * Obtiene el nombre de estado.
     * 
     * @return string
     */
    public function getEstadoNombre()
    {
        return self::NombreEstado($this->Estado);
    }

    public function DomicilioLegalAmbulante()
    {
        if ($this->getLocal()) {
            return false;
        }
    }

    /**
     * @ignore
     */
    public function getEstado()
    {
        return $this->Estado;
    }

    /**
     * @ignore
     */
    public function setEstado($Estado)
    {
        $this->Estado = $Estado;
    }

    public function getCertificadoHabilitacion()
    {
        return $this->CertificadoHabilitacion;
    }

    public function setCertificadoHabilitacion(CertificadoHabilitacionComercial $CertificadoHabilitacion)
    {
        $this->CertificadoHabilitacion = $CertificadoHabilitacion;
        return $this;
    }

    /**
     * @ignore
     */
    public function getPosicionArchivo()
    {
        return $this->PosicionArchivo;
    }

    /**
     * @ignore
     */
    public function getFechaHabilitacion()
    {
        return $this->FechaHabilitacion;
    }

    /**
     * @ignore
     */
    public function setFechaHabilitacion($FechaHabilitacion)
    {
        $this->FechaHabilitacion = $FechaHabilitacion;
        return $this;
    }

    /**
     * @ignore
     */
    public function getFechaBaja()
    {
        return $this->FechaBaja;
    }

    /**
     * @ignore
     */
    public function setFechaBaja($FechaBaja)
    {
        $this->FechaBaja = $FechaBaja;
        return $this;
    }

    /**
     * @ignore
     */
    public function getActas()
    {
        return $this->Actas;
    }

    /**
     * @ignore
     */
    public function setActas(ActaComercio $Actas)
    {
        $this->Actas = $Actas;
        return $this;
    }

    /**
     * @ignore
     */
    public function getFechaUltimaActa()
    {
        return $this->FechaUltimaActa;
    }

    /**
     * @ignore
     */
    public function setFechaUltimaActa($FechaUltimaActa)
    {
        $this->FechaUltimaActa = $FechaUltimaActa;
        return $this;
    }

    /**
     * @ignore
     */
    public function setDomicilio($Domicilio)
    {
        $this->Domicilio = $Domicilio;
        return $this;
    }

    /**
     * @ignore
     */
    public function getDomicilio()
    {
        return $this->Domicilio;
    }

    /**
     * @ignore
     */
    public function getActoAdministrativoBajaNumero()
    {
        return $this->ActoAdministrativoBajaNumero;
    }
}

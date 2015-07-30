<?php
namespace Yacare\ObrasParticularesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Representa un trámite en curso de Certificado de Aptitud Técnica Edilicia.
 *
 * @author Alejandro Diaz <alediaz.rc@gmail.com>
 *        
 *         @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 *         @ORM\Table(name="ObrasParticulares_TramiteCat")
 */
class TramiteCat extends \Yacare\TramitesBundle\Entity\Tramite
{
    use \Yacare\AdministracionBundle\Entity\ConExpediente;
    use \Yacare\ComercioBundle\Entity\ConDatosComercio;

    /**
     * Valor de uso de suelo para la partida en la cual se encuentra el local, para la actividad seleccionada.
     *
     * @see \Yacare\BaseBundle\Catastro\UsoSuelo
     *
     * @var integer @ORM\Column(type="integer", nullable=true)
     */
    private $UsoSuelo;

    public function UsoSueloNombre()
    {
        return \Yacare\CatastroBundle\Entity\UsoSuelo::UsoSueloNombre($this->getUsoSuelo());
    }

    public function getActividadPrincipal()
    {
        return $this->ActividadPrincipal;
    }

    public function setActividadPrincipal($ActividadPrincipal)
    {
        $this->ActividadPrincipal = $ActividadPrincipal;
    }

    public function getActividadSecundaria()
    {
        return $this->ActividadSecundaria;
    }

    public function setActividadSecundaria($ActividadSecundaria)
    {
        $this->ActividadSecundaria = $ActividadSecundaria;
    }

    public function getActividadTerciaria()
    {
        return $this->ActividadTerciaria;
    }

    public function setActividadTerciaria($ActividadTerciaria)
    {
        $this->ActividadTerciaria = $ActividadTerciaria;
    }

    public function getUsoSuelo()
    {
        return $this->UsoSuelo;
    }

    public function setUsoSuelo($UsoSuelo)
    {
        $this->UsoSuelo = $UsoSuelo;
    }
}

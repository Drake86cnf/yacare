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

    public function getActividad1()
    {
        return $this->Actividad1;
    }

    public function setActividad1($Actividad1)
    {
        $this->Actividad1 = $Actividad1;
    }

    public function getActividad2()
    {
        return $this->Actividad2;
    }

    public function setActividad2($Actividad2)
    {
        $this->Actividad2 = $Actividad2;
    }

    public function getActividad3()
    {
        return $this->Actividad3;
    }

    public function setActividad3($Actividad3)
    {
        $this->Actividad3 = $Actividad3;
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

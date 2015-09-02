<?php
namespace Yacare\ObrasParticularesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Representa un trámite en curso de Certificado de Aptitud Técnica Edilicia.
 *
 * @author Alejandro Diaz <alediaz.rc@gmail.com>
 *        
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 * @ORM\Table(name="ObrasParticulares_TramiteCat")
 */
class TramiteCat extends \Yacare\TramitesBundle\Entity\Tramite
{
    use \Yacare\AdministracionBundle\Entity\ConExpediente;
    use \Yacare\ComercioBundle\Entity\ConDatosComercio;
    
    /**
     * Valor de uso de suelo para la partida en la cual se encuentra el local, para la actividad seleccionada.
     * 
     * @var integer
     *
     * @see \Yacare\BaseBundle\Catastro\UsoSuelo UsoSuelo
     * 
     * @ORM\Column(type="integer", nullable=true)
     */
    private $UsoSuelo;

    /**
     * Devuelve el nombre normalizado para el UsoSuelo.
     * 
     * @return string
     */
    public function UsoSueloNombre()
    {
        return \Yacare\CatastroBundle\Entity\UsoSuelo::UsoSueloNombre($this->getUsoSuelo());
    }

    /**
     * @ignore
     */
    public function getUsoSuelo()
    {
        return $this->UsoSuelo;
    }

    /**
     * @ignore
     */
    public function setUsoSuelo($UsoSuelo)
    {
        $this->UsoSuelo = $UsoSuelo;
    }
}

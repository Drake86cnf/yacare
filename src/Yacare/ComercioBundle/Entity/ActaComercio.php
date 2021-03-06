<?php
namespace Yacare\ComercioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;

/**
 * Representa un acta de comercio.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 *
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 * @ORM\Table(name="Comercio_ActaComercio")
 */
class ActaComercio extends \Yacare\InspeccionBundle\Entity\Acta
{
    public function __construct()
    {
        $this->Etiquetas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->Nombre = 'Acta de comercio';
    }
    
    /**
     * El comercio asociado a esta acta.
     * 
     * @var \Yacare\ComercioBundle\Entity\Comercio
     *
     * @ORM\ManyToOne(targetEntity="Yacare\ComercioBundle\Entity\Comercio", inversedBy="Actas")
     * @ORM\JoinColumn(nullable=true)
     */
    protected $Comercio;
    
    /**
     * Las etiquetas asociadas al acta.
     *
     * @var \Yacare\ComercioBundle\Entity\ActaEtiqueta
     *
     * @ORM\ManyToMany(targetEntity="Yacare\ComercioBundle\Entity\ActaEtiqueta")
     * @ORM\JoinTable(name="Comercio_ActaComercio_ActaEtiqueta")
     */
    protected $Etiquetas;
    
    /**
     * La hora del acta.
     * 
     * @var string
     * 
     * @ORM\Column(type="string", nullable=true)
     */
    protected $Hora;
    
    /**
     * Setter con sanitización.
     */
    public function setHora($Hora)
    {
        $this->Hora = str_replace('.', ':', trim($Hora, "- \t\n\r\0\x0B"));
        return $this;
    }
    
    

    /**
     * @ignore
     */
    public function getComercio()
    {
        return $this->Comercio;
    }

    /**
     * @ignore
     */
    public function setComercio($Comercio)
    {
        $this->Comercio = $Comercio;
        return $this;
    }

    /**
     * @ignore
     */
    public function getEtiquetas()
    {
        return $this->Etiquetas;
    }

    /**
     * @ignore
     */
    public function setEtiquetas($Etiquetas)
    {
        $this->Etiquetas = $Etiquetas;
        return $this;
    }

    /**
     * @ignore
     */
    public function getHora()
    {
        return $this->Hora;
    }
  
}

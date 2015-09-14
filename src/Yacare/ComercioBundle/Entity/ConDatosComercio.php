<?php
namespace Yacare\ComercioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Agrega la capacidad de trabajar datos de un comercio.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
trait ConDatosComercio
{
    use \Yacare\ComercioBundle\Entity\ConActividades;
    
    /**
     * @var Local
     * 
     * @ORM\ManyToOne(targetEntity="Yacare\ComercioBundle\Entity\Local")
     * @ORM\JoinColumn(referencedColumnName="id", nullable=true)
     */
    protected $Local;

    /**
     * Devuelve el local inmueble.
     * 
     * @return Local
     */
    public function getInmueble()
    {
        return $this->Local;
    }

    /**
     * @ignore
     */
    public function getLocal()
    {
        return $this->Local;
    }

    /**
     * @ignore
     */
    public function setLocal($Local)
    {
        $this->Local = $Local;
    }
}

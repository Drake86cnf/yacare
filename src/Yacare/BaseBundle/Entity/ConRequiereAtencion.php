<?php
namespace Yacare\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Agrega la capacidad de que algo tenga una marca de "requiere atención".
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
trait ConRequiereAtencion
{
    /**
     * Indica si el elemento requiere atención.
     * 
     * @var bool
     * 
     * @ORM\Column(type="boolean", nullable=false)
     */
    protected $RequiereAtencion = false;
    
    /**
     * Indica la razón de la solicitud de atención.
     *
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $RequiereAtencionObs = null;

    /**
     * @ignore
     */
    public function getRequiereAtencion()
    {
        return $this->RequiereAtencion;
    }

    /**
     * @ignore
     */
    public function setRequiereAtencion($RequiereAtencion)
    {
        $this->RequiereAtencion = $RequiereAtencion;
        return $this;
    }

    /**
     * @ignore
     */
    public function getRequiereAtencionObs()
    {
        return $this->RequiereAtencionObs;
    }

    /**
     * @ignore
     */
    public function setRequiereAtencionObs($RequiereAtencionObs)
    {
        $this->RequiereAtencionObs = $RequiereAtencionObs;
        return $this;
    }

 }

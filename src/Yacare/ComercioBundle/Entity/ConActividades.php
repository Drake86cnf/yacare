<?php
namespace Yacare\ComercioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Agrega la capacidad para trabajar con Actividades.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 * @author Alejandro Díaz <alediaz.rc@gmail.com>
 */
trait ConActividades
{
    /**
     * @var Actividad
     * 
     * @ORM\ManyToOne(targetEntity="Yacare\ComercioBundle\Entity\Actividad")
     * @ORM\JoinColumn(referencedColumnName="id", nullable=false)
     * @Symfony\Component\Validator\Constraints\NotNull(message="Debe seleccionar una actividad principal.")
     * @Symfony\Component\Validator\Constraints\NotBlank(message="Debe elegir una actividad primaria.")
     */
    protected $Actividad1;
    
    /**
     * @var Actividad
     * 
     * @ORM\ManyToOne(targetEntity="Yacare\ComercioBundle\Entity\Actividad")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    protected $Actividad2;
    
    /**
     * @var Actividad
     * 
     * @ORM\ManyToOne(targetEntity="Yacare\ComercioBundle\Entity\Actividad")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    protected $Actividad3;
    
    /**
     * @var Actividad
     * 
     * @ORM\ManyToOne(targetEntity="Yacare\ComercioBundle\Entity\Actividad")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    protected $Actividad4;
    
    /**
     * @var Actividad
     * 
     * @ORM\ManyToOne(targetEntity="Yacare\ComercioBundle\Entity\Actividad")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    protected $Actividad5;
    
    /**
     * @var Actividad
     * 
     * @ORM\ManyToOne(targetEntity="Yacare\ComercioBundle\Entity\Actividad")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    protected $Actividad6;

    
    
    /**
     * @ignore
     */
    public function getActividad1()
    {
        return $this->Actividad1;
    }

    /**
     * @ignore
     */
    public function setActividad1($Actividad1)
    {
        $this->Actividad1 = $Actividad1;
        return $this;
    }

    /**
     * @ignore
     */
    public function getActividad2()
    {
        return $this->Actividad2;
    }

    /**
     * @ignore
     */
    public function setActividad2($Actividad2)
    {
        $this->Actividad2 = $Actividad2;
        return $this;
    }

    /**
     * @ignore
     */
    public function getActividad3()
    {
        return $this->Actividad3;
    }

    /**
     * @ignore
     */
    public function setActividad3($Actividad3)
    {
        $this->Actividad3 = $Actividad3;
        return $this;
    }

    /**
     * @ignore
     */
    public function getActividad4()
    {
        return $this->Actividad4;
    }

    /**
     * @ignore
     */
    public function setActividad4($Actividad4)
    {
        $this->Actividad4 = $Actividad4;
        return $this;
    }

    /**
     * @ignore
     */
    public function getActividad5()
    {
        return $this->Actividad5;
    }

    /**
     * @ignore
     */
    public function setActividad5($Actividad5)
    {
        $this->Actividad5 = $Actividad5;
        return $this;
    }

    /**
     * @ignore
     */
    public function getActividad6()
    {
        return $this->Actividad6;
    }

    /**
     * @ignore
     */
    public function setActividad6($Actividad6)
    {
        $this->Actividad6 = $Actividad6;
        return $this;
    }
}

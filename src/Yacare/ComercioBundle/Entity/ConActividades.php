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
     * Getter que devuelve un array, simulando una relación de muchos a muchos.
     */
    public function getActividades() {
        $res = array();
        if($this->Actividad1 != null) { $res[] = $this->Actividad1; }
        if($this->Actividad2 != null) { $res[] = $this->Actividad2; }
        if($this->Actividad3 != null) { $res[] = $this->Actividad3; }
        if($this->Actividad4 != null) { $res[] = $this->Actividad4; }
        if($this->Actividad5 != null) { $res[] = $this->Actividad5; }
        if($this->Actividad6 != null) { $res[] = $this->Actividad6; }
        return $res;
    }

    /**
     * Devuelve el factor de riesgo más alto entre las actividades del comercio.
     */
    public function ActividadesRiesgoMayor() {
        $res = 0;
        foreach($this->getActividades() as $Actividad) {
            if($Actividad->getNivelRiesgo() > $res) {
                $res = $Actividad->getNivelRiesgo();
            }
        }
        return $res;
    }

    /**
     * Devuelve true si todas las actividades tienen la etiqueta buscada.
     */
    public function ActividadesTodasTienenEtiqueta($etiq) {
        return ($this->Actividad1 == null || $this->Actividad1->ContieneEtiquetaPorCodigo($etiq))
            && ($this->Actividad2 == null || $this->Actividad2->ContieneEtiquetaPorCodigo($etiq))
            && ($this->Actividad3 == null || $this->Actividad3->ContieneEtiquetaPorCodigo($etiq))
            && ($this->Actividad4 == null || $this->Actividad4->ContieneEtiquetaPorCodigo($etiq))
            && ($this->Actividad5 == null || $this->Actividad5->ContieneEtiquetaPorCodigo($etiq))
            && ($this->Actividad6 == null || $this->Actividad6->ContieneEtiquetaPorCodigo($etiq));
    }
    

    /**
     * Devuelve true si al menos una de las actividades tiene la etiqueta buscada.
     */
    public function ActividadesAlgunaTieneEtiqueta($etiq) {
        return ($this->Actividad1 != null && $this->Actividad1->ContieneEtiquetaPorCodigo($etiq))
        || ($this->Actividad2 != null && $this->Actividad2->ContieneEtiquetaPorCodigo($etiq))
        || ($this->Actividad3 != null && $this->Actividad3->ContieneEtiquetaPorCodigo($etiq))
        || ($this->Actividad4 != null && $this->Actividad4->ContieneEtiquetaPorCodigo($etiq))
        || ($this->Actividad5 != null && $this->Actividad5->ContieneEtiquetaPorCodigo($etiq))
        || ($this->Actividad6 != null && $this->Actividad6->ContieneEtiquetaPorCodigo($etiq));
    }
    
    /**
     * Devuelve true si todas las actividades tienen la etiqueta "exenta".
     */
    public function ActividadesTodasExentas() {
        return $this->ActividadesTodasTienenEtiqueta('exenta');
    }
    
    
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

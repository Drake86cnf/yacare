<?php
namespace Yacare\ComprasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * representa una licitacion
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com
 *
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 * @ORM\Table(name="Compras_Licitacion")
 */
class Licitacion
{
    use \Tapir\BaseBundle\Entity\ConId;
    use \Tapir\BaseBundle\Entity\ConNombre;
    use \Tapir\BaseBundle\Entity\Versionable;
    use \Tapir\BaseBundle\Entity\Importable;
    use \Yacare\AdministracionBundle\Entity\ConExpediente;
    use \Tapir\BaseBundle\Entity\ConObs;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
    // use \Knp\DoctrineBehaviors\Model\Loggable\Loggable;
    
    /**
     * @var int
     * 
     * @ORM\Column(type="string", nullable=false)
     */
    private $Numero;
    
    /**
     * Complejidad de .
     * .., (0 = baja, 1 = media, 2 = alta)
     *
     * @var int
     * 
     * @ORM\Column(type="integer", nullable=false)
     */
    private $Complejidad1;
    
    /**
     * Complejidad de .
     * .., (0 = baja, 1 = media, 2 = alta)
     *
     * @var int
     * 
     * @ORM\Column(type="integer", nullable=false)
     */
    private $Complejidad2;
    
    /**
     * Complejidad de .
     * .., (0 = baja, 1 = media, 2 = alta)
     *
     * @var int
     * 
     * @ORM\Column(type="integer", nullable=false)
     */
    private $Complejidad3;
    
    /**
     * Especifica la complejidad final computada en base a Complejidad1, 2 y 3
     *
     * @var int
     * 
     * @ORM\Column(type="integer", nullable=false)
     *     
     */
    private $ComplejidadComputada;
    
    /**
     * @var \Yacare\OrganizacionBundle\Entity\Departamento
     * 
     * @ORM\ManyToOne(targetEntity="Yacare\OrganizacionBundle\Entity\Departamento")
     * @ORM\JoinColumn(referencedColumnName="id", nullable=true)
     */
    protected $Departamento;
    
    /**
     * El importe de la licitación
     *
     * @var float 
     * 
     * @ORM\Column(type="decimal", precision=14, scale=2, nullable=false)
     */
    private $PresupuestoOficial;
    
    /**
     * El coeficiente es el porcentaje utilizado para calcular el valor del pliego, según ComplejidadComputada
     *
     * @var float 
     * 
     * @ORM\Column(type="decimal", precision=14, scale=2, nullable=false)
     */
    private $PliegoCoeficiente;
    
    /**
     * El valor del pliego
     *
     * @var float 
     * 
     * @ORM\Column(type="decimal", precision=14, scale=2, nullable=false)
     */
    private $PliegoValor;

    public function ComputarComplejidad()
    {
        // Hay 27 combinaciones de complejidad (3^3):
        // Hay 3 combinaciones de 3 iguales (111, 222 y 333)
        // éstas dan como resultado el único valor posible
        // Hay 6 combinaciones de 3 desiguales (123, 321, 213, 231, etc.)
        // éstas dan como resultado 2, que es el valor promedio
        // El resto son combinaciones 2+1 (122, 313, 332, etc.)
        // éstas dan como resultado el valor mayoritario (el que se repite 2 veces)
        // A continuación el algoritmo:
        if (($this->Complejidad1 == $this->Complejidad2) && ($this->Complejidad2 == $this->Complejidad3)) {
            // Son 3 iguales
            $this->setComplejidadComputada($this->Complejidad1);
        } else 
            if ($this->Complejidad1 == $this->Complejidad2) {
                // 1 y 2 son iguales
                $this->setComplejidadComputada($this->Complejidad1);
            } else 
                if ($this->Complejidad2 == $this->Complejidad3) {
                    // 2 y 3 son iguales
                    $this->setComplejidadComputada($this->Complejidad2);
                } else 
                    if ($this->Complejidad1 == $this->Complejidad3) {
                        // 1 y 3 son iguales
                        $this->setComplejidadComputada($this->Complejidad1);
                    } else {
                        // La única que queda es que sean las 3 desiguales
                        $this->setComplejidadComputada(1);
                    }
        
        switch ($this->getComplejidadComputada()) {
            case 0:
                $this->PliegoCoeficiente = 0.015;
                break;
            case 1:
                $this->PliegoCoeficiente = 0.0225;
                break;
            case 2:
                $this->PliegoCoeficiente = 0.03;
                break;
        }
        
        $this->PliegoValor = $this->PresupuestoOficial * ($this->PliegoCoeficiente / 100);
        
        /*
         * Garantizo valores mínimos para los pliegos.
         */
        switch ($this->getComplejidadComputada()) {
            case 0:
                if ($this->PliegoValor < 1000) {
                    $this->PliegoValor = 1000;
                }
                break;
            case 1:
                if ($this->PliegoValor < 1500) {
                    $this->PliegoValor = 1500;
                }
                break;
            case 2:
                if ($this->PliegoValor < 2000) {
                    $this->PliegoValor = 2000;
                }
                break;
        }
    }

    /**
     * @ignore
     */
    public function getNumero()
    {
        return $this->Numero;
    }

    /**
     * @ignore
     */
    public function setNumero($Numero)
    {
        $this->Numero = $Numero;
    }

    /**
     * @ignore
     */
    public function getComplejidad1()
    {
        return $this->Complejidad1;
    }

    /**
     * @ignore
     */
    public function setComplejidad1($Complejidad1)
    {
        $this->Complejidad1 = $Complejidad1;
        $this->ComputarComplejidad();
    }

    /**
     * @ignore
     */
    public function getComplejidad2()
    {
        return $this->Complejidad2;
    }

    /**
     * @ignore
     */
    public function setComplejidad2($Complejidad2)
    {
        $this->Complejidad2 = $Complejidad2;
        $this->ComputarComplejidad();
    }

    /**
     * @ignore
     */
    public function getComplejidad3()
    {
        return $this->Complejidad3;
    }

    /**
     * @ignore
     */
    public function setComplejidad3($Complejidad3)
    {
        $this->Complejidad3 = $Complejidad3;
        $this->ComputarComplejidad();
    }

    /**
     * @ignore
     */
    public function getComplejidadComputada()
    {
        return $this->ComplejidadComputada;
    }

    /**
     * @ignore
     */
    public function setComplejidadComputada($ComplejidadComputada)
    {
        $this->ComplejidadComputada = $ComplejidadComputada;
    }

    /**
     * @ignore
     */
    public function getDepartamento()
    {
        return $this->Departamento;
    }

    /**
     * @ignore
     */
    public function setDepartamento($Departamento)
    {
        $this->Departamento = $Departamento;
    }

    /**
     * @ignore
     */
    public function getPresupuestoOficial()
    {
        return $this->PresupuestoOficial;
    }

    /**
     * @ignore
     */
    public function setPresupuestoOficial($PresupuestoOficial)
    {
        $this->PresupuestoOficial = $PresupuestoOficial;
        $this->ComputarComplejidad();
    }

    /**
     * @ignore
     */
    public function getPliegoValor()
    {
        return $this->PliegoValor;
    }

    /**
     * @ignore
     */
    public function getPliegoCoeficiente()
    {
        return $this->PliegoCoeficiente;
    }
}

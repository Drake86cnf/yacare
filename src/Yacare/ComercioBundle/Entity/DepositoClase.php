<?php
namespace Yacare\ComercioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Representa la clase de un depósito.
 * 
 * @author Ernesto Carrea <ernestocarra@gmail.com>
 *
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 * @ORM\Table(name="Comercio_DepositoClase")
 */
class DepositoClase
{
    use \Tapir\BaseBundle\Entity\ConId;
    use \Tapir\BaseBundle\Entity\ConNombre;
    use \Tapir\BaseBundle\Entity\Versionable;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
    
    /**
     * @var string
     * 
     * @ORM\Column(type="string")
     */
    private $Categoria;
    
    /**
     * @var integer
     * 
     * @ORM\Column(type="integer")
     */
    private $Tipo;
    
    /**
     * @var integer
     * 
     * @ORM\Column(type="integer")
     */
    private $ClaseHasta300;
    
    /**
     * @var integer
     * 
     * @ORM\Column(type="integer")
     */
    private $ClaseHasta1000;
    
    /**
     * @var integer
     * 
     * @ORM\Column(type="integer")
     */
    private $ClaseMasDe1000;

    public function __toString()
    {
        return $this->Categoria . ': ' . $this->getNombre();
    }

    /**
     * @ignore
     */
    public function getCategoria()
    {
        return $this->Categoria;
    }

    /**
     * @ignore
     */
    public function setCategoria($Categoria)
    {
        $this->Categoria = $Categoria;
        return $this;
    }

    /**
     * @ignore
     */
    public function getTipo()
    {
        return $this->Tipo;
    }

    /**
     * @ignore
     */
    public function setTipo($Tipo)
    {
        $this->Tipo = $Tipo;
        return $this;
    }

    /**
     * @ignore
     */
    public function getClaseHasta300()
    {
        return $this->ClaseHasta300;
    }

    /**
     * @ignore
     */
    public function setClaseHasta300($ClaseHasta300)
    {
        $this->ClaseHasta300 = $ClaseHasta300;
        return $this;
    }

    /**
     * @ignore
     */
    public function getClaseHasta1000()
    {
        return $this->ClaseHasta1000;
    }

    /**
     * @ignore
     */
    public function setClaseHasta1000($ClaseHasta1000)
    {
        $this->ClaseHasta1000 = $ClaseHasta1000;
        return $this;
    }

    /**
     * @ignore
     */
    public function getClaseMasDe1000()
    {
        return $this->ClaseMasDe1000;
    }

    /**
     * @ignore
     */
    public function setClaseMasDe1000($ClaseMasDe1000)
    {
        $this->ClaseMasDe1000 = $ClaseMasDe1000;
        return $this;
    }
}

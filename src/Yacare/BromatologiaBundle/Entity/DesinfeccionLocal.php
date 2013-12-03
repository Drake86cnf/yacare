<?php

namespace Yacare\BromatologiaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yacare\BromatologiaBundle\Entity\DesinfeccionLocal
 *
 * @ORM\Entity
 * @ORM\Table(name="Bromatologia_DesinfeccionLocal")
 */
class DesinfeccionLocal
{
    use \Yacare\BaseBundle\Entity\ConId;
    use \Yacare\BaseBundle\Entity\Versionable;
    use \Yacare\BaseBundle\Entity\Suprimible;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
    
    
    /**
     * @ORM\ManyToOne(targetEntity="Yacare\BaseBundle\Entity\Persona")
     * @ORM\JoinColumn(nullable=true)
     * @ORM\OrderBy({ "NombreVisible" = "ASC" })
     */
    protected $Titular;    
 
 /**
     * @ORM\ManyToOne(targetEntity="Yacare\ComercioBundle\Entity\Local")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    protected $Local;  
    
     /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    private $FechaDesinfeccionLocal;
    
    /**
     * @var integer
     * @ORM\Column(type="integer")
     */
    private $TipoDesinfeccionLocal;   
    
    
    public function getTipoDesinfeccionLocalNombre() {
        switch ($this->TipoDesinfeccionLocal){
            case 1:
                return 'Desinfección';
            case 2:
                return 'Desinsectación';
            case 3:
                return 'Desratización';
            default:
                return '???';
        }
    }
    
          public function __toString() {
        return $this->getLocal();
    }
    
    
     
    public function getTitular() {
        return $this->Titular;
    }

    public function setTitular($Titular) {
        $this->Titular = $Titular;
    }

    public function getLocal() {
        return $this->Local;
    }

    public function setLocal($Local) {
        $this->Local = $Local;
    }

    public function getFechaDesinfeccionLocal() {
        return $this->FechaDesinfeccionLocal;
    }

    public function setFechaDesinfeccionLocal(\DateTime $FechaDesinfeccionLocal) {
        $this->FechaDesinfeccionLocal = $FechaDesinfeccionLocal;
    }

    public function getTipoDesinfeccionLocal() {
        return $this->TipoDesinfeccionLocal;
    }

    public function setTipoDesinfeccionLocal($TipoDesinfeccionLocal) {
        $this->TipoDesinfeccionLocal = $TipoDesinfeccionLocal;
    }


    }

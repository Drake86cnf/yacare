<?php

namespace Yacare\BromatologiaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yacare\BromatologiaBundle\Entity\Protocolo
 *
 * @ORM\Entity
 * @ORM\Table(name="Bromatologia_Protocolo")
 */
class Analisis
{
    use \Yacare\BaseBundle\Entity\ConId;
    use \Yacare\BaseBundle\Entity\Versionable;
    use \Yacare\BaseBundle\Entity\Suprimible;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
    
    
    /**
     * @ORM\ManyToOne(targetEntity="Yacare\BaseBundle\Entity\Persona")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    protected $Persona;
   
    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $Producto;
    
     /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $Envase;
    
    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    private $FechaElaboracion;
    
    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    private $FechaVencimiento;
    
    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    private $FechaRecepcion;
    
    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $Observaciones;
    
    /**
     * @var integer
     * @ORM\Column(type="integer")
     */
    private $ActaNumero;
    
    /**
     * @var integer
     * @ORM\Column(type="integer")
     */
    private $ProtocoloNumero;
    
    /**
     * @var integer
     * @ORM\Column(type="integer")
     */
    private $Resultado;
    
      public function __toString() {
        return $this->getMatricula();
    }
        
  
}

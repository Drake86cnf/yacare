<?php

namespace Yacare\ComercioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yacare\ComercioBundle\Entity\Rubro
 *
 * @ORM\Entity
 * @ORM\Table(name="Comercio_Rubro")
 */
class Rubro
{
    use \Yacare\BaseBundle\Entity\ConId;
    use \Yacare\BaseBundle\Entity\ConNombre;
    use \Yacare\BaseBundle\Entity\Versionable;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $Codigo;
    
     /**
     * @var integer
     * @ORM\Column(type="integer")
     */
    private $Categoria;
    
     /**
     * @var integer
     * @ORM\Column(type="integer")
     */
    private $Exento;
    
    
    
    
    public function getCodigo() {
        return $this->Codigo;
    }

    public function setCodigo($Codigo) {
        $this->Codigo = $Codigo;
    }
    
    public function getCategoria() {
        return $this->Categoria;
    }

    public function setCategoria($Categoria) {
        $this->Categoria = $Categoria;
    }

    public function getExento() {
        return $this->Exento;
    }

    public function setExento($Exento) {
        $this->Exento = $Exento;
    }


}

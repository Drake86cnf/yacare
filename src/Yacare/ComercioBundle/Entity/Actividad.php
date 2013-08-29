<?php

namespace Yacare\ComercioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yacare\ComercioBundle\Entity\Actividad
 *
 * @ORM\Entity
 * @ORM\Table(name="Comercio_Actividad")
 */
class Actividad
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
     * @var string
     * @ORM\Column(type="string", length=50)
     */
    private $Clanae2010;
    
    /**
     * @var string
     * @ORM\Column(type="string", length=50)
     */
    private $Clamae2013;
    
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

    public function getClanae2010() {
        return $this->Clanae2010;
    }

    public function setClanae2010($Clanae2010) {
        $this->Clanae2010 = $Clanae2010;
    }

    public function getClamae2013() {
        return $this->Clamae2013;
    }

    public function setClamae2013($Clamae2013) {
        $this->Clamae2013 = $Clamae2013;
    }
}

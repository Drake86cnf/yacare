<?php

namespace Yacare\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yacare\BaseBundle\Entity\Adjunto
 *
 * @ORM\Table(name="Base_Adjunto")
 * @ORM\Entity
 */
class Adjunto
{
    use \Yacare\BaseBundle\Entity\ConId;
    use \Yacare\BaseBundle\Entity\ConNombre;
    use \Yacare\BaseBundle\Entity\Versionable;
    use \Yacare\BaseBundle\Entity\Suprimible;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
    
    /**
     * @var $EntidadTipo
     * @ORM\Column(type="string", length=255)
     */
    private $EntidadTipo;
    
    /**
     * @var $EntidadId
     * @ORM\Column(type="integer")
     */
    private $EntidadId;
    
    /**
     * @var $Contenido
     * @ORM\Column(type="blob")
     */
    private $Contenido;
    
    /**
     * @var $TipoMime
     * @ORM\Column(type="string", length=50)
     */
    private $TipoMime;
    

    public function getContenido() {
        return $this->Contenido;
    }

    public function setContenido($Contenido) {
        $this->Contenido = $Contenido;
    }
    
    public function getContenidoBase64() {
        return base64_encode($this->Contenido);
    }
    
    public function getTipoMime() {
        return $this->TipoMime;
    }

    public function setTipoMime($TipoMime) {
        $this->TipoMime = $TipoMime;
    }
    
    public function getEntidadTipo() {
        return $this->EntidadTipo;
    }

    public function setEntidadTipo($EntidadTipo) {
        $this->EntidadTipo = $EntidadTipo;
    }

    public function getEntidadId() {
        return $this->EntidadId;
    }

    public function setEntidadId($EntidadId) {
        $this->EntidadId = $EntidadId;
    }
}
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
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
    use \Yacare\BaseBundle\Entity\Versionable;
    use \Yacare\BaseBundle\Entity\Eliminable;

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
}
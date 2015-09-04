<?php
namespace Yacare\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Describe un contenido de impresión.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 *
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 * @ORM\Table(name="Base_Impresion")
 */
class Impresion
{
    use \Tapir\BaseBundle\Entity\ConId;
    use \Tapir\BaseBundle\Entity\Versionable;
    use \Tapir\BaseBundle\Entity\Suprimible;
    use \Tapir\BaseBundle\Entity\Importable;
    use \Tapir\BaseBundle\Entity\ConImagen;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;

    public function __construct()
    {
        $this->Token = md5(openssl_random_pseudo_bytes(256));
    }
    
    /**
     * El tipo de la entidad.
     * 
     * @var string 
     * 
     * @ORM\Column(type="string", length=255)
     */
    private $EntidadTipo;
    
    /**
     * La ID de la entidad.
     * 
     * @var integer
     * 
     * @ORM\Column(type="integer")
     */
    private $EntidadId;
    
    /**
     * La versión de la entidad.
     * 
     * @var integer
     * 
     * @ORM\Column(type="integer", nullable=true)
     */
    private $EntidadVersion;
    
    /**
     * El tipo de mime.
     * 
     * @var string
     * 
     * @ORM\Column(type="string", length=50)
     */
    private $TipoMime;
    
    /**
     * El token.
     * 
     * @var string 
     * 
     * @ORM\Column(type="string", length=255)
     */
    private $Token;
    
    /**
     * El contenido de un archivo, en forma binaria.
     * 
     * @var \Blob
     * 
     * @ORM\Column(type="blob")
     */
    private $Contenido;

    public function MiniToken()
    {
        return substr($this->Token, 26, 6);
    }

    public function getYri($incluye_version = true)
    {
        $Res = "http://yacare.riogrande.gob.ar/cp/?en=" . str_replace('/', '+', $this->getEntidadTipo()) . "&id=" .
             $this->getEntidadId();
        
        if ($incluye_version && $this->getEntidadVersion())
            $Res .= "&ver=" . $this->getEntidadVersion();
        
        $Res .= "&tk=" . $this->getToken();
        
        return $Res;
    }

    public function getYriQrBase64()
    {
        $ContenidoQr = $this->getYri(true);
        
        ob_start();
        \PHPQRCode\QRcode::png($ContenidoQr);
        $imagen_contenido = ob_get_contents();
        ob_end_clean();
        
        // PHPQRCode cambia el content-type a image/png... lo volvemos a html
        header("Content-type: text/html");
        
        return base64_encode($imagen_contenido);
    }

    /*** Getters y Setters ****/
    
    /**
     * @ignore
     */
    public function getEntidadTipo()
    {
        return $this->EntidadTipo;
    }

    /**
     * @ignore
     */
    public function setEntidadTipo($EntidadTipo)
    {
        $this->EntidadTipo = $EntidadTipo;
    }

    /**
     * @ignore
     */
    public function getEntidadId()
    {
        return $this->EntidadId;
    }

    /**
     * @ignore
     */
    public function setEntidadId($EntidadId)
    {
        $this->EntidadId = $EntidadId;
    }

    /**
     * @ignore
     */
    public function getEntidadVersion()
    {
        return $this->EntidadVersion;
    }

    /**
     * @ignore
     */
    public function setEntidadVersion($EntidadVersion)
    {
        $this->EntidadVersion = $EntidadVersion;
    }

    /**
     * @ignore
     */
    public function getTipoMime()
    {
        return $this->TipoMime;
    }

    /**
     * @ignore
     */
    public function setTipoMime($TipoMime)
    {
        $this->TipoMime = $TipoMime;
    }

    /**
     * @ignore
     */
    public function getContenido()
    {
        return $this->Contenido;
    }

    /**
     * @ignore
     */
    public function setContenido($Contenido)
    {
        $this->Contenido = $Contenido;
    }

    /**
     * @ignore
     */
    public function getToken()
    {
        return $this->Token;
    }

    /**
     * @ignore
     */
    public function setToken($Token)
    {
        $this->Token = $Token;
    }
}

<?php
namespace Yacare\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Yacare\BaseBundle\Entity\Impresion
 *
 * @ORM\Table(name="Base_Impresion")
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 */
class Impresion
{
    use\Tapir\BaseBundle\Entity\ConId;
    use\Tapir\BaseBundle\Entity\Versionable;
    use\Tapir\BaseBundle\Entity\Suprimible;
    use\Tapir\BaseBundle\Entity\Importable;
    use\Tapir\BaseBundle\Entity\ConImagen;
    use\Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;

    public function __construct()
    {
        $this->Token = md5(openssl_random_pseudo_bytes(256));
    }

    /**
     *
     * @var string $EntidadTipo
     *      @ORM\Column(type="string", length=255)
     */
    private $EntidadTipo;

    /**
     *
     * @var $EntidadId @ORM\Column(type="integer")
     */
    private $EntidadId;

    /**
     *
     * @var $EntidadVersion @ORM\Column(type="integer", nullable=true)
     */
    private $EntidadVersion;

    /**
     *
     * @var $TipoMime @ORM\Column(type="string", length=50)
     */
    private $TipoMime;

    /**
     *
     * @var $Token @ORM\Column(type="string", length=255)
     */
    private $Token;

    /**
     *
     * @var $Contenido @ORM\Column(type="blob")
     */
    private $Contenido;

    public function getYri($incluye_version = true)
    {
        $Res = "http://yacare.riogrande.gob.ar/cp/?en=" . str_replace('/', '+', $this->getEntidadTipo()) . "&id=" . $this->getEntidadId();
        
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

    public function getEntidadTipo()
    {
        return $this->EntidadTipo;
    }

    public function setEntidadTipo($EntidadTipo)
    {
        $this->EntidadTipo = $EntidadTipo;
    }

    public function getEntidadId()
    {
        return $this->EntidadId;
    }

    public function setEntidadId($EntidadId)
    {
        $this->EntidadId = $EntidadId;
    }

    public function getEntidadVersion()
    {
        return $this->EntidadVersion;
    }

    public function setEntidadVersion($EntidadVersion)
    {
        $this->EntidadVersion = $EntidadVersion;
    }

    public function getTipoMime()
    {
        return $this->TipoMime;
    }

    public function setTipoMime($TipoMime)
    {
        $this->TipoMime = $TipoMime;
    }

    public function getContenido()
    {
        return $this->Contenido;
    }

    public function setContenido($Contenido)
    {
        $this->Contenido = $Contenido;
    }

    public function getToken()
    {
        return $this->Token;
    }

    public function setToken($Token)
    {
        $this->Token = $Token;
    }
}
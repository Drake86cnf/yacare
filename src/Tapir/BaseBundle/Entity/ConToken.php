<?php
namespace Tapir\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Tapir\BaseBundle\Helper\Damm;

/**
 * Agrega la capacidad de tener un token generado de forma pseudoaleatoria.
 * 
 * Un token simple es una secuencia de números y letras que funciona como verficación de acceso a una entidad para
 * evitar identificadores previsibles.
 * 
 * El token ser una secuencia larga de caracteres está pensado para ser transmitido por medios electrónicos (e-mail,
 * URL, etc.) a diferencia del token simple.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 * @see ConTokenSimple
 */
trait ConToken
{
    public function __constructor() {
        $this->GenerarToken();
    }
    
    /**
     * El token.
     *
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $Token;
    
    /**
     * Generar un token pseudoaleatorio.
     */
    protected function GenerarToken() {
        $this->Token = toupper(substr(base64_encode(openssl_random_pseudo_bytes(32)), 0, 32));
    }
    
    /**
     * Obtiene un YRI, que es un identificador único de esta entidad.
     *
     * El YRI es una URL que apunta a una entidad.
     *
     * @param boot $incluye_version
     * Indica si el YRI es a una versión específica de la entidad (true)
     * o en general a cualquier versión disponible (false).
     */
    public function getYriConToken($incluye_version = true)
    {
        $res = $this->getYri();
        $res .= "&tk=" . $this->getToken();
    
        return $res;
    }
    
    /**
     * Obtiene un enlace QR al YRI con token, en base64.
     *
     * @return string La representación base64 del gráfico QR del YRI.
     */
    public function getYriConTokenQrBase64()
    {
        $ContenidoQr = $this->getYriConToken(true);
    
        ob_start();
        \PHPQRCode\QRcode::png($ContenidoQr);
        $imagen_contenido = ob_get_contents();
        ob_end_clean();
    
        // PHPQRCode cambia el content-type a image/png... lo volvemos a html
        header("Content-type: text/html");
        return base64_encode($imagen_contenido);
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
    public function setToken(int $Token)
    {
        $this->Token = $Token;
        return $this;
    }
}

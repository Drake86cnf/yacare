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
        $this->Token = base64_encode(openssl_random_pseudo_bytes(30));
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

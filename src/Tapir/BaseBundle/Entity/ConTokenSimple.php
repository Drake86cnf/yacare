<?php
namespace Tapir\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Tapir\BaseBundle\Helper\Damm;

/**
 * Agrega la capacidad de tener un token simple generado de forma pseudoaleatoria.
 * 
 * Un token simple es una secuencia corta de números (normalmente entre 4 y 8) que funciona como verficación de acceso
 * a una entidad para evitar identificadores previsibles o probables.
 * 
 * El token simple al ser una secuencia corta de números está pensado para ser memorizado o transmitido por medios
 * humanos, a diferencia del token regular.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 * @see ConToken
 */
trait ConTokenSimple
{
    public function __constructor()
    {
        $this->GenerarToken();
    }
    
    /**
     * El token. 
     *
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $Token;

    /**
     * Generar un token pseudoaleatorio de 8 dígitos.
     */
    protected function GenerarToken()
    {
        $this->Token = rand(10000000, 99999999);
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
        return $this;
    }
}

<?php
namespace Yacare\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Dispositivo GPS destinado a móviles municipales.
 *
 * Yacare\BaseBundle\Entity\DispositivoRastreadorGps
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 *        
 * @ORM\Table(name="Base_DispositivoRastreadorGps")
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 */
class DispositivoRastreadorGps extends \Yacare\BaseBundle\Entity\Dispositivo
{
    /**
     * @ORM\Column(type="string", length=50)
     */
    protected $TelefonoNumero;

    /**
     * @ignore
     */
    public function getTelefonoNumero()
    {
        return $this->TelefonoNumero;
    }

    /**
     * @ignore
     */
    public function setTelefonoNumero($TelefonoNumero)
    {
        $this->TelefonoNumero = $TelefonoNumero;
    }
}

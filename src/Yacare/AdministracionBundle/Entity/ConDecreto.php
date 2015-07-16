<?php
namespace Yacare\AdministracionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Agrega la capacidad de tener un número de decreto asociado.
 * 
 * @author Ernesto Carrea <equistango@gmail.com>
 */
trait ConDecreto
{
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * 
     * @Assert\Regex(
     *     pattern="/^\s*(DM|RM|DC|RC|DJ|RJ|SI|SG|SF|SA|SO|SP|AD|OR)\-(\d{1,5})\/(\d{4})\s*$/i",
     *     message="Debe escribir el número de decreto en el formato DM-1234/2015."
     * )
     */
    protected $DecretoNumero;
    

    public function getDecretoNumero()
    {
        return $this->DecretoNumero;
    }

    public function setDecretoNumero($DecretoNumero)
    {
        $this->DecretoNumero = strtoupper($DecretoNumero);
        return $this;
    }
}
<?php
namespace Yacare\AdministracionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Agrega la capacidad de estar vinculado a un decreto.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
trait ConDecreto
{
    /**
     * El número de decreto asociado, en el formato DM-1234/2015.
     * 
     * @ORM\Column(type="string", length=255, nullable=true)
     * 
     * @Assert\Regex(
     *     pattern="/^\s*(DM|RM|DC|RC|DJ|RJ|SI|SG|SF|SA|SO|SP|AD|OR)\-(\d{1,5})\/(19|20)(\d{2})\s*$/i",
     *     message="Debe escribir el número de decreto en el formato DM-1234/2015."
     * )
     */
    protected $DecretoNumero;

    /**
     * @ignore
     */
    public function getDecretoNumero()
    {
        return $this->DecretoNumero;
    }

    /**
     * @ignore
     */
    public function setDecretoNumero($DecretoNumero)
    {
        $this->DecretoNumero = $DecretoNumero;
        return $this;
    }
}
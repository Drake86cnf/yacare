<?php
namespace Yacare\AdministracionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Agrega la capacidad de estar vinculado a un expediente.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
trait ConExpediente
{
    /**
     * El número de expediente asociado.
     * 
     * @ORM\Column(type="string", length=255, nullable=true)
     * 
     * @Assert\Regex(
     *     pattern="/^\s*(\d{1,6})\/(19|20)(\d{2})\s*$/i",
     *     message="Debe escribir el número de decreto en el formato DM-1234/2015."
     * )
     */
    protected $ExpedienteNumero;

    /**
     * @ignore
     */
    public function getExpedienteNumero()
    {
        return $this->ExpedienteNumero;
    }

    /**
     * @ignore
     */
    public function setExpedienteNumero($ExpedienteNumero)
    {
        $this->ExpedienteNumero = $ExpedienteNumero;
        return $this;
    }
}
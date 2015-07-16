<?php
namespace Yacare\ExpedientesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Agrega la capcidad de estar vinculado a un expediente.
 * 
 * @author Ernesto Carrea <equistango@gmail.com>
 */
trait ConExpediente
{

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $ExpedienteNumero;

    public function getExpedienteNumero()
    {
        return $this->ExpedienteNumero;
    }

    public function setExpedienteNumero($ExpedienteNumero)
    {
        $this->ExpedienteNumero = $ExpedienteNumero;
    }
}
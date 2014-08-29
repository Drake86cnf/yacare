<?php
namespace Yacare\ExpedientesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

trait ConExpediente
{

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $ExpedienteNumero;

    /**
     * ORM\ManyToOne(targetEntity="Yacare\ExpedientesBundle\Entity\Expediente")
     */
    // protected $Expediente;
    
    /*
     * public function getExpediente() { return $this->Expediente; } public function setExpediente($Expediente) { $this->Expediente = $Expediente; }
     */
    public function getExpedienteNumero()
    {
        return $this->ExpedienteNumero;
    }

    public function setExpedienteNumero($ExpedienteNumero)
    {
        $this->ExpedienteNumero = $ExpedienteNumero;
    }
}
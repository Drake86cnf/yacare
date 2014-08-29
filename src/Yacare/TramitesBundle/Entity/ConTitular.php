<?php
namespace Yacare\TramitesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

trait ConTitular
{

    /**
     * @ORM\ManyToOne(targetEntity="Yacare\BaseBundle\Entity\Persona")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    protected $Titular;

    public function getTitular()
    {
        return $this->Titular;
    }

    public function setTitular($Titular)
    {
        $this->Titular = $Titular;
    }
}
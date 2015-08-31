<?php
namespace Yacare\TramitesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

trait ConApoderado
{
    /**
     * @var \Yacare\BaseBundle\Entity\Persona
     * 
     * @ORM\ManyToOne(targetEntity="Yacare\BaseBundle\Entity\Persona")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    protected $Apoderado;

    /**
     * @ignore
     */
    public function getApoderado()
    {
        return $this->Apoderado;
    }

    /**
     * @ignore
     */
    public function setApoderado($Apoderado)
    {
        $this->Apoderado = $Apoderado;
    }
}

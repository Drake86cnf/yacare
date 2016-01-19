<?php
namespace Yacare\TramitesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

trait ConApoderados
{
    /**
     * @var \Yacare\BaseBundle\Entity\Persona
     * 
     * @ORM\ManyToOne(targetEntity="Yacare\BaseBundle\Entity\Persona")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    protected $Apoderado;
    
    /**
     * @var \Yacare\BaseBundle\Entity\Persona
     *
     * @ORM\ManyToOne(targetEntity="Yacare\BaseBundle\Entity\Persona")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    protected $Apoderado2;

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

    /**
     * @ignore
     */
    public function getApoderado2()
    {
        return $this->Apoderado2;
    }

    /**
     * @ignore
     */
    public function setApoderado2($Apoderado2)
    {
        $this->Apoderado2 = $Apoderado2;
        return $this;
    }
 
}

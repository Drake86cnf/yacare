<?php

namespace Yacare\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ConObs
 *
 */
trait ConObs
{
    /**
     * @var string $Obs
     * @ORM\Column(type="text", nullable=true)
     */
    private $Obs;
    
    public function setObs($obs)
    {
        $this->Obs = $obs;
    }

    public function getObs()
    {
        return $this->Obs;
    }
}

<?php

namespace Tapir\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ConObs
 *
 */
trait ConObs
{
    /**
     * @var string $obs
     * @ORM\Column(type="text", nullable=true)
     */
    private $obs;
    
    public function getObs() {
        return $this->obs;
    }

    public function setObs($obs) {
        $this->obs = $obs;
    }

}

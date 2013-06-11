<?php

namespace Yacare\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ConNombre
 *
 */
trait ConNombre
{
    public function __toString() {
        return $this->getNombre();
    }
}

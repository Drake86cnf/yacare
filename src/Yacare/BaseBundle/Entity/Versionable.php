<?php

namespace Yacare\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Versionable
 *
 */
trait Versionable
{
    /**
     * @var integer $Version
     *
     * @ORM\Column(name="Version", type="integer")
     * @ORM\Version
     */
    private $Version;
    
    public function getVersion() {
        return $this->Version;
    }

    public function setVersion($Version) {
        $this->Version = $Version;
    }
}

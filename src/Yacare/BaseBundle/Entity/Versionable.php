<?php

namespace Yacare\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EntidadVersionable
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

    /**
     * @var integer $TimeStamp
     *
     * @ORM\Column(name="TimeStamp", type="datetime")
     * @ORM\Version
     */
    private $TimeStamp;
    
    public function getVersion() {
        return $this->Version;
    }

    public function setVersion($Version) {
        $this->Version = $Version;
    }

    public function getTimeStamp() {
        return $this->TimeStamp;
    }

    public function setTimeStamp($TimeStamp) {
        $this->TimeStamp = $TimeStamp;
    }
}

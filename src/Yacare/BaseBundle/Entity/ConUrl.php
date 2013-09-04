<?php

namespace Yacare\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ConUrl
 *
 */
trait ConUrl
{
    /**
     * @var string $Url
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Url;
    
    public function getUrl() {
        return $this->Url;
    }

    public function setUrl($Url) {
        $this->Url = $Url;
    }
}

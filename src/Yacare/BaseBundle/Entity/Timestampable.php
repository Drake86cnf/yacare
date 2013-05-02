<?php

namespace Yacare\BaseBundle\Entity;

trait Timestampable
{
    /**
    * @var DateTime $CreatedAt
    *
    * @ORM\Column(type="datetime", nullable=true)
    */
    protected $CreatedAt;

    /**
    * @var DateTime $UpdatedAt
    *
    * @ORM\Column(type="datetime", nullable=true)
    */
    protected $UpdatedAt;

    /**
    * Returns createdAt value.
    *
    * @return DateTime
    */
    public function getCreatedAt()
    {
        return $this->CreatedAt;
    }

    /**
    * Returns updatedAt value.
    *
    * @return DateTime
    */
    public function getUpdatedAt()
    {
        return $this->UpdatedAt;
    }

    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->CreatedAt = $createdAt;
    }

    public function setUpdatedAt(\DateTime $updatedAt)
    {
        $this->UpdatedAt = $updatedAt;
    }

    /**
    * Updates createdAt and updatedAt timestamps.
    */
    public function UpdateTimestamps()
    {
        if (null === $this->CreatedAt) {
            $this->CreatedAt = new \DateTime('now');
        }

        $this->UpdatedAt = new \DateTime('now');
    }
}

<?php

namespace Indepnet\GlpiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TicketFollowup
 *
 * @ORM\Table(name="glpi_ticketfollowups", indexes={
 *      @ORM\Index(name="date", columns={"date"}),
 *      @ORM\Index(name="users_id", columns={"users_id"}),
 *      @ORM\Index(name="tickets_id", columns={"tickets_id"}),
 *      @ORM\Index(name="is_private", columns={"is_private"}),
 *      @ORM\Index(name="requesttypes_id", columns={"requesttypes_id"})
 * })
 * @ORM\Entity
 */
class TicketFollowup
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="Indepnet\GlpiBundle\Entity\Ticket")
     * @ORM\JoinColumn(name="tickets_id", referencedColumnName="id", nullable=false)
     */
    private $Ticket;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=true)
     */
    private $Date;

    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="Indepnet\GlpiBundle\Entity\User")
     * @ORM\JoinColumn(name="users_id", referencedColumnName="id", nullable=false)
     */
    private $User;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text", nullable=true)
     */
    private $Content;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_private", type="boolean", nullable=false)
     */
    private $IsPrivate;

    /**
     * @var integer
     *
     * @ORM\Column(name="requesttypes_id", type="integer", nullable=false)
     */
    private $RequestTypesId;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getTicket()
    {
        return $this->Ticket;
    }

    public function setTicket($Ticket)
    {
        $this->Ticket = $Ticket;
        return $this;
    }

    public function getDate()
    {
        return $this->Date;
    }

    public function setDate(\DateTime $Date)
    {
        $this->Date = $Date;
        return $this;
    }

    public function getUser()
    {
        return $this->User;
    }

    public function setUser($User)
    {
        $this->User = $User;
        return $this;
    }

    public function getContent()
    {
        return $this->Content;
    }

    public function setContent($Content)
    {
        $this->Content = $Content;
        return $this;
    }

    public function getIsPrivate()
    {
        return $this->IsPrivate;
    }

    public function setIsPrivate($IsPrivate)
    {
        $this->IsPrivate = $IsPrivate;
        return $this;
    }

    public function getRequestTypesId()
    {
        return $this->RequestTypesId;
    }

    public function setRequestTypesId($RequestTypesId)
    {
        $this->RequestTypesId = $RequestTypesId;
        return $this;
    }
 
    
    
    
}

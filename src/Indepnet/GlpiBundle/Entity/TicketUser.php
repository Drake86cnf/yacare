<?php

namespace Indepnet\GlpiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TicketUser
 *
 * @ORM\Table(name="glpi_tickets_users", uniqueConstraints={
 *      @ORM\UniqueConstraint(name="unicity", columns={"tickets_id", "type", "users_id", "alternative_email"})},
 *          indexes={@ORM\Index(name="user", columns={"users_id", "type"})})
 * @ORM\Entity
 */
class TicketUser
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
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="Indepnet\GlpiBundle\Entity\User")
     * @ORM\JoinColumn(name="users_id", referencedColumnName="id", nullable=false)
     */
    private $User;

    /**
     * @var integer
     * 
     * 1 = Requester, 2 = Resolver, 3 = Watcher
     *
     * @ORM\Column(name="type", type="integer", nullable=false)
     */
    private $Type;

    /**
     * @var boolean
     * 
     * 0 for no email notification, 1 for email notifications
     *
     * @ORM\Column(name="use_notification", type="boolean", nullable=false)
     */
    private $UseNotification;

    /**
     * @var string
     *
     * @ORM\Column(name="alternative_email", type="string", length=255, nullable=true)
     */
    private $AlternativeEmail;
    
    
    public static function TypeNameFromNumber($num) {
        switch($num) {
            case 1: return 'Solicitante';
            case 2: return 'Encargado';
            case 3: return 'Observador';
            default: return $num;
        }
    }
    
    public function TypeName() {
        return TicketUser::TypeNameFromNumber($this->Type);
    }
    

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

    public function getUser()
    {
        return $this->User;
    }

    public function setUser($User)
    {
        $this->User = $User;
        return $this;
    }

    public function getType()
    {
        return $this->Type;
    }

    public function setType($Type)
    {
        $this->Type = $Type;
        return $this;
    }

    public function getUseNotification()
    {
        return $this->UseNotification;
    }

    public function setUseNotification($UseNotification)
    {
        $this->UseNotification = $UseNotification;
        return $this;
    }

    public function getAlternativeEmail()
    {
        return $this->AlternativeEmail;
    }

    public function setAlternativeEmail($AlternativeEmail)
    {
        $this->AlternativeEmail = $AlternativeEmail;
        return $this;
    }
}

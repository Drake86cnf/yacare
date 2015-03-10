<?php

namespace Indepnet\GlpiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ticket
 *
 * @ORM\Table(name="glpi_tickets", indexes={@ORM\Index(name="date", columns={"date"}), @ORM\Index(name="closedate", columns={"closedate"}), @ORM\Index(name="status", columns={"status"}), @ORM\Index(name="priority", columns={"priority"}), @ORM\Index(name="request_type", columns={"requesttypes_id"}), @ORM\Index(name="date_mod", columns={"date_mod"}), @ORM\Index(name="entities_id", columns={"entities_id"}), @ORM\Index(name="users_id_recipient", columns={"users_id_recipient"}), @ORM\Index(name="item", columns={"itemtype", "items_id"}), @ORM\Index(name="solvedate", columns={"solvedate"}), @ORM\Index(name="urgency", columns={"urgency"}), @ORM\Index(name="impact", columns={"impact"}), @ORM\Index(name="global_validation", columns={"global_validation"}), @ORM\Index(name="slas_id", columns={"slas_id"}), @ORM\Index(name="slalevels_id", columns={"slalevels_id"}), @ORM\Index(name="due_date", columns={"due_date"}), @ORM\Index(name="users_id_lastupdater", columns={"users_id_lastupdater"}), @ORM\Index(name="type", columns={"type"}), @ORM\Index(name="solutiontypes_id", columns={"solutiontypes_id"}), @ORM\Index(name="itilcategories_id", columns={"itilcategories_id"}), @ORM\Index(name="is_deleted", columns={"is_deleted"}), @ORM\Index(name="name", columns={"name"}), @ORM\Index(name="locations_id", columns={"locations_id"})})
 * @ORM\Entity
 */
class Ticket
{
    public function __construct()
    {
        $this->FollowUps = new \Doctrine\Common\Collections\ArrayCollection();
        $this->Users = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
        
    /**
     * @var integer
     *
     * @ORM\Column(name="entities_id", type="integer", nullable=false)
     */
    private $entitiesId;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $Name;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=true)
     */
    private $Date;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="closedate", type="datetime", nullable=true)
     */
    private $CloseDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="solvedate", type="datetime", nullable=true)
     */
    private $SolveDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_mod", type="datetime", nullable=true)
     */
    private $DateMod;

    /**
     * @var integer
     *
     * @ORM\Column(name="users_id_lastupdater", type="integer", nullable=false)
     */
    private $UsersIdLastUpdater;

    /**
     * @var integer
     *
     * @ORM\Column(name="status", type="integer", nullable=false)
     */
    private $Status;

    /**
     * @var integer
     *
     * @ORM\Column(name="users_id_recipient", type="integer", nullable=false)
     */
    private $UsersIdRecipient;

    /**
     * @var integer
     *
     * @ORM\Column(name="requesttypes_id", type="integer", nullable=false)
     */
    private $RequestTypesId;

    /**
     * @var string
     *
     * @ORM\Column(name="itemtype", type="string", length=100, nullable=false)
     */
    private $ItemType;

    /**
     * @var integer
     *
     * @ORM\Column(name="items_id", type="integer", nullable=false)
     */
    private $ItemsId;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text", nullable=true)
     */
    private $Content;

    /**
     * @var integer
     *
     * @ORM\Column(name="urgency", type="integer", nullable=false)
     */
    private $Urgency;

    /**
     * @var integer
     *
     * @ORM\Column(name="impact", type="integer", nullable=false)
     */
    private $Impact;

    /**
     * @var integer
     *
     * @ORM\Column(name="priority", type="integer", nullable=false)
     */
    private $Priority;

    
    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="Indepnet\GlpiBundle\Entity\ItilCategory")
     * @ORM\JoinColumn(name="itilcategories_id", referencedColumnName="id", nullable=false)
     */
    private $ItilCategory;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="type", type="integer", nullable=false)
     */
    private $Type;

    /**
     * @var integer
     *
     * @ORM\Column(name="solutiontypes_id", type="integer", nullable=false)
     */
    private $SolutionTypesId;

    /**
     * @var string
     *
     * @ORM\Column(name="solution", type="text", length=65535, nullable=true)
     */
    private $Solution;

    /**
     * @var integer
     *
     * @ORM\Column(name="global_validation", type="integer", nullable=false)
     */
    private $GlobalValidation;

    /**
     * @var integer
     *
     * @ORM\Column(name="slas_id", type="integer", nullable=false)
     */
    private $SlasId;

    /**
     * @var integer
     *
     * @ORM\Column(name="slalevels_id", type="integer", nullable=false)
     */
    private $SlaLevelsId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="due_date", type="datetime", nullable=true)
     */
    private $DueDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="begin_waiting_date", type="datetime", nullable=true)
     */
    private $BeginWaitingDate;

    /**
     * @var integer
     *
     * @ORM\Column(name="sla_waiting_duration", type="integer", nullable=false)
     */
    private $SlaWaitingDuration;

    /**
     * @var integer
     *
     * @ORM\Column(name="waiting_duration", type="integer", nullable=false)
     */
    private $WaitingDuration;

    /**
     * @var integer
     *
     * @ORM\Column(name="close_delay_stat", type="integer", nullable=false)
     */
    private $CloseDelayStat;

    /**
     * @var integer
     *
     * @ORM\Column(name="solve_delay_stat", type="integer", nullable=false)
     */
    private $SolveDelayStat;

    /**
     * @var integer
     *
     * @ORM\Column(name="takeintoaccount_delay_stat", type="integer", nullable=false)
     */
    private $TakeIntoAccountDelayStat;

    /**
     * @var integer
     *
     * @ORM\Column(name="actiontime", type="integer", nullable=false)
     */
    private $ActionTime;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_deleted", type="boolean", nullable=false)
     */
    private $IsDeleted;

    /**
     * @var integer
     *
     * @ORM\Column(name="locations_id", type="integer", nullable=false)
     */
    private $LocationsId;

    /**
     * @var integer
     *
     * @ORM\Column(name="validation_percent", type="integer", nullable=false)
     */
    private $ValidationPercent;
    
    /**
     * @ORM\OneToMany(targetEntity="TicketUser", mappedBy="Ticket")
     */
    private $Users;
    
    /**
     * @ORM\OneToMany(targetEntity="TicketFollowup", mappedBy="Ticket")
     */
    private $FollowUps;
    
    
    public static function StatusNameFromNumber($num) {
        switch($num) {
            //case 1: return '';
            case 2: return 'En curso (asignado)';
            //case 3: return '';
            //case 4: return '';
            //case 5: return '';
            case 6: return 'Cerrado';
            //case 1: return '';
            //case 1: return '';
            default: return $num;
        }
    }
    
    public function StatusName() {
        return Ticket::StatusNameFromNumber($this->Status);
    }
    
    
    public static function PriorityNameFromNumber($num) {
        switch($num) {
            //case 1: return 'Very low';
            //case 2: return 'Low';
            case 3: return 'Mediana';
            case 4: return 'Urgente';
            //case 5: return 'Very high';
            default: return $num;
        }
    }
    
    public function PriorityName() {
        return Ticket::PriorityNameFromNumber($this->Priority);
    }
    
    /*
     * Getters y setters.
     */

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getEntitiesId()
    {
        return $this->entitiesId;
    }

    public function setEntitiesId($entitiesId)
    {
        $this->entitiesId = $entitiesId;
        return $this;
    }

    public function getName()
    {
        return $this->Name;
    }

    public function setName($Name)
    {
        $this->Name = $Name;
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

    public function getCloseDate()
    {
        return $this->CloseDate;
    }

    public function setCloseDate(\DateTime $CloseDate)
    {
        $this->CloseDate = $CloseDate;
        return $this;
    }

    public function getSolveDate()
    {
        return $this->SolveDate;
    }

    public function setSolveDate(\DateTime $SolveDate)
    {
        $this->SolveDate = $SolveDate;
        return $this;
    }

    public function getDateMod()
    {
        return $this->DateMod;
    }

    public function setDateMod(\DateTime $DateMod)
    {
        $this->DateMod = $DateMod;
        return $this;
    }

    public function getUsersIdLastUpdater()
    {
        return $this->UsersIdLastUpdater;
    }

    public function setUsersIdLastUpdater($UsersIdLastUpdater)
    {
        $this->UsersIdLastUpdater = $UsersIdLastUpdater;
        return $this;
    }

    public function getStatus()
    {
        return $this->Status;
    }

    public function setStatus($Status)
    {
        $this->Status = $Status;
        return $this;
    }

    public function getUsersIdRecipient()
    {
        return $this->UsersIdRecipient;
    }

    public function setUsersIdRecipient($UsersIdRecipient)
    {
        $this->UsersIdRecipient = $UsersIdRecipient;
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

    public function getItemType()
    {
        return $this->ItemType;
    }

    public function setItemType($ItemType)
    {
        $this->ItemType = $ItemType;
        return $this;
    }

    public function getItemsId()
    {
        return $this->ItemsId;
    }

    public function setItemsId($ItemsId)
    {
        $this->ItemsId = $ItemsId;
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

    public function getUrgency()
    {
        return $this->Urgency;
    }

    public function setUrgency($Urgency)
    {
        $this->Urgency = $Urgency;
        return $this;
    }

    public function getImpact()
    {
        return $this->Impact;
    }

    public function setImpact($Impact)
    {
        $this->Impact = $Impact;
        return $this;
    }

    public function getPriority()
    {
        return $this->Priority;
    }

    public function setPriority($Priority)
    {
        $this->Priority = $Priority;
        return $this;
    }

    public function getItilCategory()
    {
        return $this->ItilCategory;
    }

    public function setItilCategory($ItilCategory)
    {
        $this->ItilCategory = $ItilCategory;
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

    public function getSolutionTypesId()
    {
        return $this->SolutionTypesId;
    }

    public function setSolutionTypesId($SolutionTypesId)
    {
        $this->SolutionTypesId = $SolutionTypesId;
        return $this;
    }

    public function getSolution()
    {
        return $this->Solution;
    }

    public function setSolution($Solution)
    {
        $this->Solution = $Solution;
        return $this;
    }

    public function getGlobalValidation()
    {
        return $this->GlobalValidation;
    }

    public function setGlobalValidation($GlobalValidation)
    {
        $this->GlobalValidation = $GlobalValidation;
        return $this;
    }

    public function getSlasId()
    {
        return $this->SlasId;
    }

    public function setSlasId($SlasId)
    {
        $this->SlasId = $SlasId;
        return $this;
    }

    public function getSlaLevelsId()
    {
        return $this->SlaLevelsId;
    }

    public function setSlaLevelsId($SlaLevelsId)
    {
        $this->SlaLevelsId = $SlaLevelsId;
        return $this;
    }

    public function getDueDate()
    {
        return $this->DueDate;
    }

    public function setDueDate(\DateTime $DueDate)
    {
        $this->DueDate = $DueDate;
        return $this;
    }

    public function getBeginWaitingDate()
    {
        return $this->BeginWaitingDate;
    }

    public function setBeginWaitingDate(\DateTime $BeginWaitingDate)
    {
        $this->BeginWaitingDate = $BeginWaitingDate;
        return $this;
    }

    public function getSlaWaitingDuration()
    {
        return $this->SlaWaitingDuration;
    }

    public function setSlaWaitingDuration($SlaWaitingDuration)
    {
        $this->SlaWaitingDuration = $SlaWaitingDuration;
        return $this;
    }

    public function getWaitingDuration()
    {
        return $this->WaitingDuration;
    }

    public function setWaitingDuration($WaitingDuration)
    {
        $this->WaitingDuration = $WaitingDuration;
        return $this;
    }

    public function getCloseDelayStat()
    {
        return $this->CloseDelayStat;
    }

    public function setCloseDelayStat($CloseDelayStat)
    {
        $this->CloseDelayStat = $CloseDelayStat;
        return $this;
    }

    public function getSolveDelayStat()
    {
        return $this->SolveDelayStat;
    }

    public function setSolveDelayStat($SolveDelayStat)
    {
        $this->SolveDelayStat = $SolveDelayStat;
        return $this;
    }

    public function getTakeIntoAccountDelayStat()
    {
        return $this->TakeIntoAccountDelayStat;
    }

    public function setTakeIntoAccountDelayStat($TakeIntoAccountDelayStat)
    {
        $this->TakeIntoAccountDelayStat = $TakeIntoAccountDelayStat;
        return $this;
    }

    public function getActionTime()
    {
        return $this->ActionTime;
    }

    public function setActionTime($ActionTime)
    {
        $this->ActionTime = $ActionTime;
        return $this;
    }

    public function getIsDeleted()
    {
        return $this->IsDeleted;
    }

    public function setIsDeleted($IsDeleted)
    {
        $this->IsDeleted = $IsDeleted;
        return $this;
    }

    public function getLocationsId()
    {
        return $this->LocationsId;
    }

    public function setLocationsId($LocationsId)
    {
        $this->LocationsId = $LocationsId;
        return $this;
    }

    public function getValidationPercent()
    {
        return $this->ValidationPercent;
    }

    public function setValidationPercent($ValidationPercent)
    {
        $this->ValidationPercent = $ValidationPercent;
        return $this;
    }

    public function getUsers()
    {
        return $this->Users;
    }

    public function setUsers($Users)
    {
        $this->Users = $Users;
        return $this;
    }

    public function getFollowUps()
    {
        return $this->FollowUps;
    }

    public function setFollowUps($FollowUps)
    {
        $this->FollowUps = $FollowUps;
        return $this;
    }
 
}

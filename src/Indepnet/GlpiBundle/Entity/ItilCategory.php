<?php

namespace Indepnet\GlpiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ItilCategory
 *
 * @ORM\Table(name="glpi_itilcategories", indexes={
 *      @ORM\Index(name="name", columns={"name"}),
 *      @ORM\Index(name="entities_id", columns={"entities_id"}),
 *      @ORM\Index(name="is_recursive", columns={"is_recursive"}),
 *      @ORM\Index(name="knowbaseitemcategories_id", columns={"knowbaseitemcategories_id"}),
 *      @ORM\Index(name="users_id", columns={"users_id"}),
 *      @ORM\Index(name="groups_id", columns={"groups_id"}),
 *      @ORM\Index(name="is_helpdeskvisible", columns={"is_helpdeskvisible"}),
 *      @ORM\Index(name="itilcategories_id", columns={"itilcategories_id"}),
 *      @ORM\Index(name="tickettemplates_id_incident", columns={"tickettemplates_id_incident"}),
 *      @ORM\Index(name="tickettemplates_id_demand", columns={"tickettemplates_id_demand"}),
 *      @ORM\Index(name="is_incident", columns={"is_incident"}), 
 *      @ORM\Index(name="is_request", columns={"is_request"}),
 *      @ORM\Index(name="is_problem", columns={"is_problem"}),
 *      @ORM\Index(name="is_change", columns={"is_change"})})
 * @ORM\Entity
 */
class ItilCategory
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
     * @var integer
     *
     * @ORM\Column(name="entities_id", type="integer", nullable=false)
     */
    private $EntitiesId;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_recursive", type="boolean", nullable=false)
     */
    private $IsRecursive;

    /**
     * @var integer
     *
     * @ORM\Column(name="itilcategories_id", type="integer", nullable=false)
     */
    private $itilcategoriesId;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $Name;

    /**
     * @var string
     *
     * @ORM\Column(name="completename", type="text", length=65535, nullable=true)
     */
    private $CompleteName;

    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="text", length=65535, nullable=true)
     */
    private $Comment;

    /**
     * @var integer
     *
     * @ORM\Column(name="level", type="integer", nullable=false)
     */
    private $Level;

    /**
     * @var integer
     *
     * @ORM\Column(name="knowbaseitemcategories_id", type="integer", nullable=false)
     */
    private $KnowBaseItemCategoriesId;

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
     * @ORM\Column(name="groups_id", type="integer", nullable=false)
     */
    private $GroupsId;

    /**
     * @var string
     *
     * @ORM\Column(name="ancestors_cache", type="text", nullable=true)
     */
    private $AncestorsCache;

    /**
     * @var string
     *
     * @ORM\Column(name="sons_cache", type="text", nullable=true)
     */
    private $SonsCache;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_helpdeskvisible", type="boolean", nullable=false)
     */
    private $IsHelpdeskVisible;

    /**
     * @var integer
     *
     * @ORM\Column(name="tickettemplates_id_incident", type="integer", nullable=false)
     */
    private $TicketTemplatesIdIncident;

    /**
     * @var integer
     *
     * @ORM\Column(name="tickettemplates_id_demand", type="integer", nullable=false)
     */
    private $TicketTemplatesIdDemand;

    /**
     * @var integer
     *
     * @ORM\Column(name="is_incident", type="integer", nullable=false)
     */
    private $IsIncident;

    /**
     * @var integer
     *
     * @ORM\Column(name="is_request", type="integer", nullable=false)
     */
    private $IsRequest;

    /**
     * @var integer
     *
     * @ORM\Column(name="is_problem", type="integer", nullable=false)
     */
    private $IsProblem;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_change", type="boolean", nullable=false)
     */
    private $IsChange;
    
    public function __toString() {
        return $this->CompleteName;
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

    public function getEntitiesId()
    {
        return $this->EntitiesId;
    }

    public function setEntitiesId($EntitiesId)
    {
        $this->EntitiesId = $EntitiesId;
        return $this;
    }

    public function getIsRecursive()
    {
        return $this->IsRecursive;
    }

    public function setIsRecursive($IsRecursive)
    {
        $this->IsRecursive = $IsRecursive;
        return $this;
    }

    public function getItilcategoriesId()
    {
        return $this->itilcategoriesId;
    }

    public function setItilcategoriesId($itilcategoriesId)
    {
        $this->itilcategoriesId = $itilcategoriesId;
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

    public function getCompleteName()
    {
        return $this->CompleteName;
    }

    public function setCompleteName($CompleteName)
    {
        $this->CompleteName = $CompleteName;
        return $this;
    }

    public function getComment()
    {
        return $this->Comment;
    }

    public function setComment($Comment)
    {
        $this->Comment = $Comment;
        return $this;
    }

    public function getLevel()
    {
        return $this->Level;
    }

    public function setLevel($Level)
    {
        $this->Level = $Level;
        return $this;
    }

    public function getKnowBaseItemCategoriesId()
    {
        return $this->KnowBaseItemCategoriesId;
    }

    public function setKnowBaseItemCategoriesId($KnowBaseItemCategoriesId)
    {
        $this->KnowBaseItemCategoriesId = $KnowBaseItemCategoriesId;
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

    public function getGroupsId()
    {
        return $this->GroupsId;
    }

    public function setGroupsId($GroupsId)
    {
        $this->GroupsId = $GroupsId;
        return $this;
    }

    public function getAncestorsCache()
    {
        return $this->AncestorsCache;
    }

    public function setAncestorsCache($AncestorsCache)
    {
        $this->AncestorsCache = $AncestorsCache;
        return $this;
    }

    public function getSonsCache()
    {
        return $this->SonsCache;
    }

    public function setSonsCache($SonsCache)
    {
        $this->SonsCache = $SonsCache;
        return $this;
    }

    public function getIsHelpdeskVisible()
    {
        return $this->IsHelpdeskVisible;
    }

    public function setIsHelpdeskVisible($IsHelpdeskVisible)
    {
        $this->IsHelpdeskVisible = $IsHelpdeskVisible;
        return $this;
    }

    public function getTicketTemplatesIdIncident()
    {
        return $this->TicketTemplatesIdIncident;
    }

    public function setTicketTemplatesIdIncident($TicketTemplatesIdIncident)
    {
        $this->TicketTemplatesIdIncident = $TicketTemplatesIdIncident;
        return $this;
    }

    public function getTicketTemplatesIdDemand()
    {
        return $this->TicketTemplatesIdDemand;
    }

    public function setTicketTemplatesIdDemand($TicketTemplatesIdDemand)
    {
        $this->TicketTemplatesIdDemand = $TicketTemplatesIdDemand;
        return $this;
    }

    public function getIsIncident()
    {
        return $this->IsIncident;
    }

    public function setIsIncident($IsIncident)
    {
        $this->IsIncident = $IsIncident;
        return $this;
    }

    public function getIsRequest()
    {
        return $this->IsRequest;
    }

    public function setIsRequest($IsRequest)
    {
        $this->IsRequest = $IsRequest;
        return $this;
    }

    public function getIsProblem()
    {
        return $this->IsProblem;
    }

    public function setIsProblem($IsProblem)
    {
        $this->IsProblem = $IsProblem;
        return $this;
    }

    public function getIsChange()
    {
        return $this->IsChange;
    }

    public function setIsChange($IsChange)
    {
        $this->IsChange = $IsChange;
        return $this;
    }
 

}

<?php
namespace Indepnet\GlpiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="glpi_users", uniqueConstraints={
 *      @ORM\UniqueConstraint(name="unicity", columns={"name"})}, indexes={
 *          @ORM\Index(name="firstname", columns={"firstname"}),
 *          @ORM\Index(name="realname", columns={"realname"}),
 *          @ORM\Index(name="entities_id", columns={"entities_id"}),
 *          @ORM\Index(name="profiles_id", columns={"profiles_id"}),
 *          @ORM\Index(name="locations_id", columns={"locations_id"}),
 *          @ORM\Index(name="usertitles_id", columns={"usertitles_id"}),
 *          @ORM\Index(name="usercategories_id", columns={"usercategories_id"}),
 *          @ORM\Index(name="is_deleted", columns={"is_deleted"}),
 *          @ORM\Index(name="is_active", columns={"is_active"}),
 *          @ORM\Index(name="date_mod", columns={"date_mod"}),
 *          @ORM\Index(name="authitem", columns={"authtype", "auths_id"}),
 *          @ORM\Index(name="is_deleted_ldap", columns={"is_deleted_ldap"})
 * })
 * @ORM\Entity
 */
class User
{
    public function __construct()
    {
        $this->Tickets = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     *
     * @var integer @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    
    /**
     *
     * @var string
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $Name;

    /**
     *
     * @var string 
     * @ORM\Column(name="password", type="string", length=255, nullable=true)
     */
    private $Password;

    /**
     *
     * @var string @ORM\Column(name="phone", type="string", length=255, nullable=true)
     */
    private $Phone;

    /**
     *
     * @var string @ORM\Column(name="phone2", type="string", length=255, nullable=true)
     */
    private $Phone2;

    /**
     *
     * @var string @ORM\Column(name="mobile", type="string", length=255, nullable=true)
     */
    private $Mobile;

    /**
     *
     * @var string @ORM\Column(name="realname", type="string", length=255, nullable=true)
     */
    private $RealName;

    /**
     *
     * @var string @ORM\Column(name="firstname", type="string", length=255, nullable=true)
     */
    private $FirstName;

    /**
     *
     * @var integer @ORM\Column(name="locations_id", type="integer", nullable=false)
     */
    private $locationsId;

    /**
     *
     * @var string @ORM\Column(name="language", type="string", length=10, nullable=true)
     */
    private $Language;

    /**
     *
     * @var integer @ORM\Column(name="use_mode", type="integer", nullable=false)
     */
    private $UseMode;

    /**
     *
     * @var integer @ORM\Column(name="list_limit", type="integer", nullable=true)
     */
    private $ListLimit;

    /**
     *
     * @var boolean @ORM\Column(name="is_active", type="boolean", nullable=false)
     */
    private $IsActive;

    /**
     *
     * @var string @ORM\Column(name="comment", type="text", length=65535, nullable=true)
     */
    private $Comment;

    /**
     *
     * @var integer @ORM\Column(name="auths_id", type="integer", nullable=false)
     */
    private $authsId;

    /**
     *
     * @var integer @ORM\Column(name="authtype", type="integer", nullable=false)
     */
    private $AuthType;

    /**
     *
     * @var \DateTime @ORM\Column(name="last_login", type="datetime", nullable=true)
     */
    private $LastLogin;

    /**
     *
     * @var \DateTime @ORM\Column(name="date_mod", type="datetime", nullable=true)
     */
    private $DateMod;

    /**
     *
     * @var \DateTime @ORM\Column(name="date_sync", type="datetime", nullable=true)
     */
    private $DateSync;

    /**
     *
     * @var boolean @ORM\Column(name="is_deleted", type="boolean", nullable=false)
     */
    private $IsDeleted;

    /**
     *
     * @var integer @ORM\Column(name="profiles_id", type="integer", nullable=false)
     */
    private $profilesId;

    /**
     *
     * @var integer @ORM\Column(name="entities_id", type="integer", nullable=false)
     */
    private $entitiesId;

    /**
     *
     * @var integer @ORM\Column(name="usertitles_id", type="integer", nullable=false)
     */
    private $usertitlesId;

    /**
     *
     * @var integer @ORM\Column(name="usercategories_id", type="integer", nullable=false)
     */
    private $usercategoriesId;

    /**
     *
     * @var integer @ORM\Column(name="date_format", type="integer", nullable=true)
     */
    private $DateFormat;

    /**
     *
     * @var integer @ORM\Column(name="number_format", type="integer", nullable=true)
     */
    private $NumberFormat;

    /**
     *
     * @var integer @ORM\Column(name="names_format", type="integer", nullable=true)
     */
    private $NamesFormat;

    /**
     *
     * @var string @ORM\Column(name="csv_delimiter", type="string", length=1, nullable=true)
     */
    private $CsvDelimiter;

    /**
     *
     * @var boolean @ORM\Column(name="is_ids_visible", type="boolean", nullable=true)
     */
    private $IsIdsVisible;

    /**
     *
     * @var integer @ORM\Column(name="dropdown_chars_limit", type="integer", nullable=true)
     */
    private $DropdownCharsLimit;

    /**
     *
     * @var boolean @ORM\Column(name="use_flat_dropdowntree", type="boolean", nullable=true)
     */
    private $UseFlatDropdownTree;

    /**
     *
     * @var boolean @ORM\Column(name="show_jobs_at_login", type="boolean", nullable=true)
     */
    private $ShowJobsAtLogin;

    /**
     *
     * @var string @ORM\Column(name="priority_1", type="string", length=20, nullable=true)
     */
    private $Priority1;

    /**
     *
     * @var string @ORM\Column(name="priority_2", type="string", length=20, nullable=true)
     */
    private $Priority2;

    /**
     *
     * @var string @ORM\Column(name="priority_3", type="string", length=20, nullable=true)
     */
    private $Priority3;

    /**
     *
     * @var string @ORM\Column(name="priority_4", type="string", length=20, nullable=true)
     */
    private $Priority4;

    /**
     *
     * @var string @ORM\Column(name="priority_5", type="string", length=20, nullable=true)
     */
    private $Priority5;

    /**
     *
     * @var string @ORM\Column(name="priority_6", type="string", length=20, nullable=true)
     */
    private $Priority6;

    /**
     *
     * @var boolean @ORM\Column(name="followup_private", type="boolean", nullable=true)
     */
    private $FollowupPrivate;

    /**
     *
     * @var boolean @ORM\Column(name="task_private", type="boolean", nullable=true)
     */
    private $TaskPrivate;

    /**
     *
     * @var integer @ORM\Column(name="default_requesttypes_id", type="integer", nullable=true)
     */
    private $defaultRequesttypesId;

    /**
     *
     * @var string @ORM\Column(name="password_forget_token", type="string", length=40, nullable=true)
     */
    private $PasswordForgetToken;

    /**
     *
     * @var \DateTime @ORM\Column(name="password_forget_token_date", type="datetime", nullable=true)
     */
    private $PasswordForgetTokenDate;

    /**
     *
     * @var string @ORM\Column(name="user_dn", type="text", length=65535, nullable=true)
     */
    private $UserDn;

    /**
     *
     * @var string @ORM\Column(name="registration_number", type="string", length=255, nullable=true)
     */
    private $RegistrationNumber;

    /**
     *
     * @var boolean @ORM\Column(name="show_count_on_tabs", type="boolean", nullable=true)
     */
    private $ShowCountOnTabs;

    /**
     *
     * @var integer @ORM\Column(name="refresh_ticket_list", type="integer", nullable=true)
     */
    private $RefreshTicketList;

    /**
     *
     * @var boolean @ORM\Column(name="set_default_tech", type="boolean", nullable=true)
     */
    private $SetDefaultTech;

    /**
     *
     * @var string @ORM\Column(name="personal_token", type="string", length=255, nullable=true)
     */
    private $PersonalToken;

    /**
     *
     * @var \DateTime @ORM\Column(name="personal_token_date", type="datetime", nullable=true)
     */
    private $PersonalTokenDate;

    /**
     *
     * @var integer @ORM\Column(name="display_count_on_home", type="integer", nullable=true)
     */
    private $DisplayCountOnHome;

    /**
     *
     * @var boolean @ORM\Column(name="notification_to_myself", type="boolean", nullable=true)
     */
    private $NotificationToMyself;

    /**
     *
     * @var string @ORM\Column(name="duedateok_color", type="string", length=255, nullable=true)
     */
    private $DueDateOkColor;

    /**
     *
     * @var string @ORM\Column(name="duedatewarning_color", type="string", length=255, nullable=true)
     */
    private $DueDateWarningColor;

    /**
     *
     * @var string @ORM\Column(name="duedatecritical_color", type="string", length=255, nullable=true)
     */
    private $DueDateCriticalColor;

    /**
     *
     * @var integer @ORM\Column(name="duedatewarning_less", type="integer", nullable=true)
     */
    private $DueDateWarningLess;

    /**
     *
     * @var integer @ORM\Column(name="duedatecritical_less", type="integer", nullable=true)
     */
    private $DueDateCriticalLess;

    /**
     *
     * @var string @ORM\Column(name="duedatewarning_unit", type="string", length=255, nullable=true)
     */
    private $DueDateWarningUnit;

    /**
     *
     * @var string @ORM\Column(name="duedatecritical_unit", type="string", length=255, nullable=true)
     */
    private $DueDateCriticalUnit;

    /**
     *
     * @var string @ORM\Column(name="display_options", type="text", length=65535, nullable=true)
     */
    private $DisplayOptions;

    /**
     *
     * @var boolean @ORM\Column(name="is_deleted_ldap", type="boolean", nullable=false)
     */
    private $IsDeletedLdap;

    /**
     *
     * @var string @ORM\Column(name="pdffont", type="string", length=255, nullable=true)
     */
    private $pdfFont;

    /**
     *
     * @var string @ORM\Column(name="picture", type="string", length=255, nullable=true)
     */
    private $Picture;

    /**
     *
     * @var \DateTime @ORM\Column(name="begin_date", type="datetime", nullable=true)
     */
    private $BeginDate;

    /**
     *
     * @var \DateTime @ORM\Column(name="end_date", type="datetime", nullable=true)
     */
    private $EndDate;

    /**
     *
     * @var boolean @ORM\Column(name="keep_devices_when_purging_item", type="boolean", nullable=true)
     */
    private $KeepDevicesWhenPurgingItem;

    /**
     *
     * @var string @ORM\Column(name="privatebookmarkorder", type="text", nullable=true)
     */
    private $PrivateBookmarkOrder;

    /**
     *
     * @var boolean @ORM\Column(name="backcreated", type="boolean", nullable=true)
     */
    private $BackCreated;

    /**
     * @ORM\OneToMany(targetEntity="TicketUser", mappedBy="User")
     */
    private $Tickets;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
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

    public function getPassword()
    {
        return $this->Password;
    }

    public function setPassword($Password)
    {
        $this->Password = $Password;
        return $this;
    }

    public function getPhone()
    {
        return $this->Phone;
    }

    public function setPhone($Phone)
    {
        $this->Phone = $Phone;
        return $this;
    }

    public function getPhone2()
    {
        return $this->Phone2;
    }

    public function setPhone2($Phone2)
    {
        $this->Phone2 = $Phone2;
        return $this;
    }

    public function getMobile()
    {
        return $this->Mobile;
    }

    public function setMobile($Mobile)
    {
        $this->Mobile = $Mobile;
        return $this;
    }

    public function getRealName()
    {
        return $this->RealName;
    }

    public function setRealName($RealName)
    {
        $this->RealName = $RealName;
        return $this;
    }

    public function getFirstName()
    {
        return $this->FirstName;
    }

    public function setFirstName($FirstName)
    {
        $this->FirstName = $FirstName;
        return $this;
    }

    public function getLocationsId()
    {
        return $this->locationsId;
    }

    public function setLocationsId($locationsId)
    {
        $this->locationsId = $locationsId;
        return $this;
    }

    public function getLanguage()
    {
        return $this->Language;
    }

    public function setLanguage($Language)
    {
        $this->Language = $Language;
        return $this;
    }

    public function getUseMode()
    {
        return $this->UseMode;
    }

    public function setUseMode($UseMode)
    {
        $this->UseMode = $UseMode;
        return $this;
    }

    public function getListLimit()
    {
        return $this->ListLimit;
    }

    public function setListLimit($ListLimit)
    {
        $this->ListLimit = $ListLimit;
        return $this;
    }

    public function getIsActive()
    {
        return $this->IsActive;
    }

    public function setIsActive($IsActive)
    {
        $this->IsActive = $IsActive;
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

    public function getAuthsId()
    {
        return $this->authsId;
    }

    public function setAuthsId($authsId)
    {
        $this->authsId = $authsId;
        return $this;
    }

    public function getAuthType()
    {
        return $this->AuthType;
    }

    public function setAuthType($AuthType)
    {
        $this->AuthType = $AuthType;
        return $this;
    }

    public function getLastLogin()
    {
        return $this->LastLogin;
    }

    public function setLastLogin(\DateTime $LastLogin)
    {
        $this->LastLogin = $LastLogin;
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

    public function getDateSync()
    {
        return $this->DateSync;
    }

    public function setDateSync(\DateTime $DateSync)
    {
        $this->DateSync = $DateSync;
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

    public function getProfilesId()
    {
        return $this->profilesId;
    }

    public function setProfilesId($profilesId)
    {
        $this->profilesId = $profilesId;
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

    public function getUsertitlesId()
    {
        return $this->usertitlesId;
    }

    public function setUsertitlesId($usertitlesId)
    {
        $this->usertitlesId = $usertitlesId;
        return $this;
    }

    public function getUsercategoriesId()
    {
        return $this->usercategoriesId;
    }

    public function setUsercategoriesId($usercategoriesId)
    {
        $this->usercategoriesId = $usercategoriesId;
        return $this;
    }

    public function getDateFormat()
    {
        return $this->DateFormat;
    }

    public function setDateFormat($DateFormat)
    {
        $this->DateFormat = $DateFormat;
        return $this;
    }

    public function getNumberFormat()
    {
        return $this->NumberFormat;
    }

    public function setNumberFormat($NumberFormat)
    {
        $this->NumberFormat = $NumberFormat;
        return $this;
    }

    public function getNamesFormat()
    {
        return $this->NamesFormat;
    }

    public function setNamesFormat($NamesFormat)
    {
        $this->NamesFormat = $NamesFormat;
        return $this;
    }

    public function getCsvDelimiter()
    {
        return $this->CsvDelimiter;
    }

    public function setCsvDelimiter($CsvDelimiter)
    {
        $this->CsvDelimiter = $CsvDelimiter;
        return $this;
    }

    public function getIsIdsVisible()
    {
        return $this->IsIdsVisible;
    }

    public function setIsIdsVisible($IsIdsVisible)
    {
        $this->IsIdsVisible = $IsIdsVisible;
        return $this;
    }

    public function getDropdownCharsLimit()
    {
        return $this->DropdownCharsLimit;
    }

    public function setDropdownCharsLimit($DropdownCharsLimit)
    {
        $this->DropdownCharsLimit = $DropdownCharsLimit;
        return $this;
    }

    public function getUseFlatDropdownTree()
    {
        return $this->UseFlatDropdownTree;
    }

    public function setUseFlatDropdownTree($UseFlatDropdownTree)
    {
        $this->UseFlatDropdownTree = $UseFlatDropdownTree;
        return $this;
    }

    public function getShowJobsAtLogin()
    {
        return $this->ShowJobsAtLogin;
    }

    public function setShowJobsAtLogin($ShowJobsAtLogin)
    {
        $this->ShowJobsAtLogin = $ShowJobsAtLogin;
        return $this;
    }

    public function getPriority1()
    {
        return $this->Priority1;
    }

    public function setPriority1($Priority1)
    {
        $this->Priority1 = $Priority1;
        return $this;
    }

    public function getPriority2()
    {
        return $this->Priority2;
    }

    public function setPriority2($Priority2)
    {
        $this->Priority2 = $Priority2;
        return $this;
    }

    public function getPriority3()
    {
        return $this->Priority3;
    }

    public function setPriority3($Priority3)
    {
        $this->Priority3 = $Priority3;
        return $this;
    }

    public function getPriority4()
    {
        return $this->Priority4;
    }

    public function setPriority4($Priority4)
    {
        $this->Priority4 = $Priority4;
        return $this;
    }

    public function getPriority5()
    {
        return $this->Priority5;
    }

    public function setPriority5($Priority5)
    {
        $this->Priority5 = $Priority5;
        return $this;
    }

    public function getPriority6()
    {
        return $this->Priority6;
    }

    public function setPriority6($Priority6)
    {
        $this->Priority6 = $Priority6;
        return $this;
    }

    public function getFollowupPrivate()
    {
        return $this->FollowupPrivate;
    }

    public function setFollowupPrivate($FollowupPrivate)
    {
        $this->FollowupPrivate = $FollowupPrivate;
        return $this;
    }

    public function getTaskPrivate()
    {
        return $this->TaskPrivate;
    }

    public function setTaskPrivate($TaskPrivate)
    {
        $this->TaskPrivate = $TaskPrivate;
        return $this;
    }

    public function getDefaultRequesttypesId()
    {
        return $this->defaultRequesttypesId;
    }

    public function setDefaultRequesttypesId($defaultRequesttypesId)
    {
        $this->defaultRequesttypesId = $defaultRequesttypesId;
        return $this;
    }

    public function getPasswordForgetToken()
    {
        return $this->PasswordForgetToken;
    }

    public function setPasswordForgetToken($PasswordForgetToken)
    {
        $this->PasswordForgetToken = $PasswordForgetToken;
        return $this;
    }

    public function getPasswordForgetTokenDate()
    {
        return $this->PasswordForgetTokenDate;
    }

    public function setPasswordForgetTokenDate(\DateTime $PasswordForgetTokenDate)
    {
        $this->PasswordForgetTokenDate = $PasswordForgetTokenDate;
        return $this;
    }

    public function getUserDn()
    {
        return $this->UserDn;
    }

    public function setUserDn($UserDn)
    {
        $this->UserDn = $UserDn;
        return $this;
    }

    public function getRegistrationNumber()
    {
        return $this->RegistrationNumber;
    }

    public function setRegistrationNumber($RegistrationNumber)
    {
        $this->RegistrationNumber = $RegistrationNumber;
        return $this;
    }

    public function getShowCountOnTabs()
    {
        return $this->ShowCountOnTabs;
    }

    public function setShowCountOnTabs($ShowCountOnTabs)
    {
        $this->ShowCountOnTabs = $ShowCountOnTabs;
        return $this;
    }

    public function getRefreshTicketList()
    {
        return $this->RefreshTicketList;
    }

    public function setRefreshTicketList($RefreshTicketList)
    {
        $this->RefreshTicketList = $RefreshTicketList;
        return $this;
    }

    public function getSetDefaultTech()
    {
        return $this->SetDefaultTech;
    }

    public function setSetDefaultTech($SetDefaultTech)
    {
        $this->SetDefaultTech = $SetDefaultTech;
        return $this;
    }

    public function getPersonalToken()
    {
        return $this->PersonalToken;
    }

    public function setPersonalToken($PersonalToken)
    {
        $this->PersonalToken = $PersonalToken;
        return $this;
    }

    public function getPersonalTokenDate()
    {
        return $this->PersonalTokenDate;
    }

    public function setPersonalTokenDate(\DateTime $PersonalTokenDate)
    {
        $this->PersonalTokenDate = $PersonalTokenDate;
        return $this;
    }

    public function getDisplayCountOnHome()
    {
        return $this->DisplayCountOnHome;
    }

    public function setDisplayCountOnHome($DisplayCountOnHome)
    {
        $this->DisplayCountOnHome = $DisplayCountOnHome;
        return $this;
    }

    public function getNotificationToMyself()
    {
        return $this->NotificationToMyself;
    }

    public function setNotificationToMyself($NotificationToMyself)
    {
        $this->NotificationToMyself = $NotificationToMyself;
        return $this;
    }

    public function getDueDateOkColor()
    {
        return $this->DueDateOkColor;
    }

    public function setDueDateOkColor($DueDateOkColor)
    {
        $this->DueDateOkColor = $DueDateOkColor;
        return $this;
    }

    public function getDueDateWarningColor()
    {
        return $this->DueDateWarningColor;
    }

    public function setDueDateWarningColor($DueDateWarningColor)
    {
        $this->DueDateWarningColor = $DueDateWarningColor;
        return $this;
    }

    public function getDueDateCriticalColor()
    {
        return $this->DueDateCriticalColor;
    }

    public function setDueDateCriticalColor($DueDateCriticalColor)
    {
        $this->DueDateCriticalColor = $DueDateCriticalColor;
        return $this;
    }

    public function getDueDateWarningLess()
    {
        return $this->DueDateWarningLess;
    }

    public function setDueDateWarningLess($DueDateWarningLess)
    {
        $this->DueDateWarningLess = $DueDateWarningLess;
        return $this;
    }

    public function getDueDateCriticalLess()
    {
        return $this->DueDateCriticalLess;
    }

    public function setDueDateCriticalLess($DueDateCriticalLess)
    {
        $this->DueDateCriticalLess = $DueDateCriticalLess;
        return $this;
    }

    public function getDueDateWarningUnit()
    {
        return $this->DueDateWarningUnit;
    }

    public function setDueDateWarningUnit($DueDateWarningUnit)
    {
        $this->DueDateWarningUnit = $DueDateWarningUnit;
        return $this;
    }

    public function getDueDateCriticalUnit()
    {
        return $this->DueDateCriticalUnit;
    }

    public function setDueDateCriticalUnit($DueDateCriticalUnit)
    {
        $this->DueDateCriticalUnit = $DueDateCriticalUnit;
        return $this;
    }

    public function getDisplayOptions()
    {
        return $this->DisplayOptions;
    }

    public function setDisplayOptions($DisplayOptions)
    {
        $this->DisplayOptions = $DisplayOptions;
        return $this;
    }

    public function getIsDeletedLdap()
    {
        return $this->IsDeletedLdap;
    }

    public function setIsDeletedLdap($IsDeletedLdap)
    {
        $this->IsDeletedLdap = $IsDeletedLdap;
        return $this;
    }

    public function getPdfFont()
    {
        return $this->pdfFont;
    }

    public function setPdfFont($pdfFont)
    {
        $this->pdfFont = $pdfFont;
        return $this;
    }

    public function getPicture()
    {
        return $this->Picture;
    }

    public function setPicture($Picture)
    {
        $this->Picture = $Picture;
        return $this;
    }

    public function getBeginDate()
    {
        return $this->BeginDate;
    }

    public function setBeginDate(\DateTime $BeginDate)
    {
        $this->BeginDate = $BeginDate;
        return $this;
    }

    public function getEndDate()
    {
        return $this->EndDate;
    }

    public function setEndDate(\DateTime $EndDate)
    {
        $this->EndDate = $EndDate;
        return $this;
    }

    public function getKeepDevicesWhenPurgingItem()
    {
        return $this->KeepDevicesWhenPurgingItem;
    }

    public function setKeepDevicesWhenPurgingItem($KeepDevicesWhenPurgingItem)
    {
        $this->KeepDevicesWhenPurgingItem = $KeepDevicesWhenPurgingItem;
        return $this;
    }

    public function getPrivateBookmarkOrder()
    {
        return $this->PrivateBookmarkOrder;
    }

    public function setPrivateBookmarkOrder($PrivateBookmarkOrder)
    {
        $this->PrivateBookmarkOrder = $PrivateBookmarkOrder;
        return $this;
    }

    public function getBackCreated()
    {
        return $this->BackCreated;
    }

    public function setBackCreated($BackCreated)
    {
        $this->BackCreated = $BackCreated;
        return $this;
    }

    public function getTickets()
    {
        return $this->Tickets;
    }

    public function setTickets($Tickets)
    {
        $this->Tickets = $Tickets;
        return $this;
    }
 

    }

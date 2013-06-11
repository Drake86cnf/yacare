<?php

namespace Yacare\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Yacare\BaseBundle\Entity\Usuario
 *
 * @ORM\Table(name="Base_Usuario")
 * @ORM\Entity
 */
class Usuario implements UserInterface, \Serializable
{
    public function __construct()
    {
        $this->Salt = md5(uniqid(null, true));
    }
    
    /**
     * @var integer $id
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @ORM\Column(type="string", length=25, unique=true)
     */
    private $Username;

    /**
     * @ORM\Column(type="string", length=32)
     */
    private $Salt;

    /**
     * @ORM\Column(type="string", length=40)
     */
    private $Password;
    
    /**
     * @ORM\ManyToOne(targetEntity="Persona")
     * @ORM\JoinColumn(referencedColumnName="id", nullable=false)
     */
    protected $Persona;

    /**
     * Get id
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * @inheritDoc
     */
    public function eraseCredentials()
    {
        return;
    }
    
    public function isEqualTo(UserInterface $user)
    {
        return $this->id === $user->getId();
    }

    
    public function isAccountNonExpired()
    {
        return true;
    }

    public function isAccountNonLocked()
    {
        return true;
    }

    public function isCredentialsNonExpired()
    {
        return true;
    }

    public function isEnabled()
    {
        return $this->isActive;
    }
    
    public function getRoles()
    {
        return null;
    }

    /**
     * @see \Serializable::serialize()
     */
    public function serialize()
    {
        return serialize(array(
            $this->id,
        ));
    }

    /**
     * @see \Serializable::unserialize()
     */
    public function unserialize($serialized)
    {
        list (
            $this->id,
        ) = unserialize($serialized);
    }
    
    public function getUsername() {
        return $this->Username;
    }

    public function setUsername($Username) {
        $this->Username = $Username;
    }

    public function getSalt() {
        return $this->Salt;
    }

    public function setSalt($Salt) {
        $this->Salt = $Salt;
    }

    public function getPassword() {
        return $this->Password;
    }

    public function setPassword($Password) {
        $this->Password = $Password;
    }
    
    public function getPersona() {
        return $this->Persona;
    }

    public function setPersona($Persona) {
        $this->Persona = $Persona;
    }
}

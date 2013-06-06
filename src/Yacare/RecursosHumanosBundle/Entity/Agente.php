<?php

namespace Yacare\RecursosHumanosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Yacare\RecursosHumanosBundle\Entity\Agente
 *
 * @ORM\Table(name="Rrhh_Agente")
 * @ORM\Entity
 */
class Agente implements UserInterface, \Serializable
{
    /*
    CREATE OR REPLACE VIEW yacare.Rrhh_Agente AS 
        SELECT agentes.legajo AS id, agentes.fechaingre AS FechaIngreso, agentes.nombre AS NombreVisible,
            agentes.username, agentes.salt, agentes.password, agentes.is_active, 
            agentes.NombreSolo as Nombre, agentes.Apellido, agentes.email
        FROM rr_hh.agentes;
    
    ALTER TABLE rr_hh.agentes
        ADD username VARCHAR(25) NOT NULL DEFAULT '',
        ADD salt VARCHAR(32) NOT NULL DEFAULT '',
        ADD password VARCHAR(40) NOT NULL DEFAULT '',
        ADD NombreSolo VARCHAR(255) NOT NULL DEFAULT '',
        ADD Apellido VARCHAR(255) NOT NULL DEFAULT '',
        CHANGE fechaingre fechaingre DATE NOT NULL,
        CHANGE nombre nombre VARCHAR(255) NOT NULL DEFAULT '',
        CHANGE email email VARCHAR(255) NOT NULL DEFAULT '';
    
    UPDATE yacare.Rrhh_Agente SET salt=MD5(RAND()) WHERE salt='';
    UPDATE rr_hh.agentes SET Apellido=TRIM(SUBSTRING_INDEX(nombre, ' ', 1)) WHERE NombreSolo='';
    UPDATE rr_hh.agentes SET NombreSolo=TRIM(TRIM(LEADING Apellido FROM nombre)) WHERE NombreSolo='';
       
     */
    
    public function __construct()
    {
        $this->salt = md5(uniqid(null, true));
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
     * @ORM\Column(type="string", length=25, unique=true, nullable=true)
     */
    private $username = '';

    /**
     * @ORM\Column(type="string", length=32)
     */
    private $salt = '';

    /**
     * @ORM\Column(type="string", length=40)
     */
    private $password = '';

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $email = '';

    /**
     * @var \DateTime
     * @ORM\Column(type="date")
     */
    private $FechaIngreso;
    
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Nombre;
    
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Apellido;
    
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $NombreVisible;
    
    /**
     * Get id
     *
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
    
    
    public function __toString() {
        return $this->getNombreVisible();
    }
    

    public function getFechaIngreso() {
        return $this->FechaIngreso;
    }

    public function setFechaIngreso(\DateTime $FechaIngreso) {
        $this->FechaIngreso = $FechaIngreso;
    }
    
    public function getUsername() {
        return $this->username;
    }

    public function setUsername($username) {
        $this->username = $username;
    }

    public function getSalt() {
        return $this->salt;
    }

    public function setSalt($salt) {
        $this->salt = $salt;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getNombre() {
        return $this->Nombre;
    }

    public function setNombre($Nombre) {
        $this->NombreVisible = $this->Apellido . ', ' . $this->Nombre;
        $this->Nombre = $Nombre;
    }

    public function getApellido() {
        return $this->Apellido;
    }

    public function setApellido($Apellido) {
        $this->NombreVisible = $this->Apellido . ', ' . $this->Nombre;
        $this->Apellido = $Apellido;
    }

    public function getNombreVisible() {
        $this->NombreVisible = $this->Apellido . ', ' . $this->Nombre;
        return $this->NombreVisible;
    }

    public function setNombreVisible($NombreVisible) {
        $this->NombreVisible = $this->Apellido . ', ' . $this->Nombre;
    }
}

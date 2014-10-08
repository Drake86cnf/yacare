<?php
namespace Yacare\MunirgBundle\Helper;

use Symfony\Component\DependencyInjection\ContainerInterface as Container;

class LdapHelper
{
    protected $adldap = null;
    
    public function __construct() {
        $this->ObtenerConexion();
    }
    
    public function __destruct() {
        $this->adldap->close();
    }
    
    public function ObtenerConexion() {
        $this->adldap = new \adLDAP\adLDAP(array('base_dn' => 'DC=riogrande,DC=local', 'account_suffix'=>'@riogrande.local', 'domain_controllers' => array('192.168.100.43')));
        $this->adldap->close();
        $this->adldap->setAdminUsername('Administrator');
        $this->adldap->setAdminPassword('S1ni3sTr0');
        $this->adldap->connect();
    }
    
    
    public function ObtenerGrupos() {
        return $this->adldap->group()->all();
    }
    
    public function AgregarGrupo($entity) {
        $add = array();
        $add["cn"] = $entity->getNombreLdap();
        $add["samaccountname"] = $entity->getNombreLdap();
        $add["objectClass"] = "Group";
        $add["description"] = $entity->getNombre();
        return ldap_add($this->adldap->getLdapConnection(), "CN=" . $add["cn"] . ",CN=Users," . $this->adldap->getBaseDn(), $add);
        //return $this->adldap->group()->create($attributes);
    }
    
    
    public function ModificarGrupo($entity) {
        $add = array();
        $add["description"] = $entity->getNombre();
        return ldap_mod_replace($this->adldap->getLdapConnection(), "CN=" . $entity->getNombreLdap() . ",CN=Users," . $this->adldap->getBaseDn(), $add);
        //return $this->adldap->group()->create($attributes);
    }
}

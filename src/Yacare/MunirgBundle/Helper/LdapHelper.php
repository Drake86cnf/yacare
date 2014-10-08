<?php
namespace Yacare\MunirgBundle\Helper;

use Symfony\Component\DependencyInjection\ContainerInterface as Container;

class LdapHelper
{
    protected $adldap = null;
    protected $adldap2 = null;

    protected $GruposLdapRg = null;
    protected $GruposLdapMuni = null;
    
    public function __construct() {
        $this->ObtenerConexion();
    }
    
    public function __destruct() {
        $this->adldaprg->close();
    }
    
    public function ObtenerConexion() {
        $this->adldaprg = new \adLDAP\adLDAP(array('base_dn' => 'DC=riogrande,DC=local', 'account_suffix'=>'@riogrande.local', 'domain_controllers' => array('192.168.100.43')));
        $this->adldaprg->close();
        $this->adldaprg->setAdminUsername('Administrator');
        $this->adldaprg->setAdminPassword('S1ni3sTr0');
        $this->adldaprg->connect();
        
        $this->adldaprgmuni = new \adLDAP\adLDAP(array('base_dn' => 'DC=municipiorg,DC=gob,DC=ar', 'account_suffix'=>'@municipiorg.gob.ar', 'domain_controllers' => array('192.168.100.44')));
        $this->adldaprgmuni->close();
        $this->adldaprgmuni->setAdminUsername('Administrador');
        $this->adldaprgmuni->setAdminPassword('S1ni3sTr0');
        $this->adldaprgmuni->connect();
    }
    
    
    public function ObtenerGrupos() {
        if(!$this->GruposLdapRg) {
            $this->GruposLdapRg = $this->adldaprg->group()->all();
        }
        
        if(!$this->GruposLdapMuni) {
            $this->GruposLdapMuni = $this->adldaprgmuni->group()->all();
        }
        
        return $this->GruposLdapRg;
    }
    
    
    public function AgregarOActualizarGrupo($entity) {
        $nombreLdap = $entity->getNombreLdap();
        if($nombreLdap) {
            $this->ObtenerGrupos();
            if(in_array($nombreLdap, $this->GruposLdapRg) == false) {
                $add = array();
                $add["cn"] = $entity->getNombreLdap();
                $add["samaccountname"] = $entity->getNombreLdap();
                $add["objectClass"] = "Group";
                $add["description"] = $entity->getNombre();
                ldap_add($this->adldaprg->getLdapConnection(), "CN=" . $add["cn"] . ",CN=Users," . $this->adldaprg->getBaseDn(), $add);
            } else {
                $add = array();
                $add["description"] = $entity->getNombre();
                ldap_mod_replace($this->adldaprg->getLdapConnection(), "CN=" . $entity->getNombreLdap() . ",CN=Users," . $this->adldaprg->getBaseDn(), $add);
            }
            
            
            if(in_array($nombreLdap, $this->GruposLdapMuni) == false) {
                $add = array();
                $add["cn"] = $entity->getNombreLdap();
                $add["samaccountname"] = $entity->getNombreLdap();
                $add["objectClass"] = "Group";
                $add["description"] = $entity->getNombre();
                ldap_add($this->adldaprgmuni->getLdapConnection(), "CN=" . $add["cn"] . ",CN=Users," . $this->adldaprgmuni->getBaseDn(), $add);
            } else {
                $add = array();
                $add["description"] = $entity->getNombre();
                ldap_mod_replace($this->adldaprgmuni->getLdapConnection(), "CN=" . $entity->getNombreLdap() . ",CN=Users," . $this->adldaprgmuni->getBaseDn(), $add);
            }
        }
    }

}

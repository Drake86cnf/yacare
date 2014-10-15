<?php
namespace Yacare\MunirgBundle\Helper;

use Symfony\Component\DependencyInjection\ContainerInterface as Container;

class AdConnection
{
    /**
     * Holds the LDAP connection.
     */
    private $conn;

    /**
     * Domain controller name or address.
     */
    protected $Controller, $Domain;

    protected $UseSsl = false, $FollowReferrals = false;

    protected $AccountSuffix, $BaseDn;

    protected $AdminUsername, $AdminPassword;
    
    public $DomainAdminsGroupName = 'Domain Admins';
    
    const UAC_ACCOUNTDISABLE = 2;
    const UAC_PASSWD_NOTREQD = 32;
    const UAC_PASSWD_CANT_CHANGE = 64;
    const UAC_NORMAL_ACCOUNT = 512;
    const UAC_DONT_EXPIRE_PASSWORD = 65536;

    public function __construct($controller, $domain, $adminUsername, $adminPassword)
    {
        $this->Controller = $controller;
        $this->Domain = $domain;
        $this->AdminUsername = $adminUsername;
        $this->AdminPassword = $adminPassword;
        $this->AccountSuffix = "@" . $domain;
        $this->BaseDn = 'DC=' . join(',DC=', explode('.', $this->Domain));
    }

    public function Connect()
    {
        if ($this->UseSsl) {
            $this->conn = ldap_connect("ldaps://" . $this->Controller);
        } else {
            $this->conn = ldap_connect("ldap://" . $this->Controller);
        }
        
        ldap_set_option($this->conn, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($this->conn, LDAP_OPT_REFERRALS, $this->FollowReferrals ? 1 : 0);
        
        if ($this->AdminUsername !== null && $this->AdminPassword !== null) {
            ldap_bind($this->conn, $this->AdminUsername . $this->AccountSuffix, $this->AdminPassword);
        }
    }

    
    public function UserMod($username, $attributes = array())
    {
        // Clone the attributes array
        $attr = array_merge($attributes, array());
        
        $Usr = $this->UserGet($username);
        if($Usr) {
            $OldCn = $Usr['cn'];
            $NewCn = $attr['cn'];
            if($NewCn == $OldCn) {
                // Same CN, no need to pass it as an argument
                unset($attr['cn']);
            } else {
                // Rename user 
                ldap_rename($this->conn, 'CN=' . $OldCn . ',CN=Users,' . $this->BaseDn, 'CN=' . $NewCn, null, true);
                unset($attr['cn']);
            }
            
            return ldap_modify($this->conn, $this->GetUserDnByCn($NewCn), $attr);
        } else {
            return;
        }
    }
    
    
    public function UserAdd($username, $attributes = array())
    {
        // Clone the attributes array
        $attr = array_merge($attributes, array());
        
        $UserDn = $this->GetUserDnByCn($attr['cn']);
        
        $attr['objectClass'] = array('top', 'person', 'organizationalPerson', 'user');
        return ldap_add($this->conn, $UserDn, $attr);
    }
    
    
    
    public function UserGet($username) {
        $Users = $this->UserSearch($username);
        if(count($Users) == 1) {
            return $Users[0];
        } else {
            return null;
        }
    }
    
    
    public function UserSetPass($username, $newpass) {
        $attr = array('unicodePwd' => $this->EncodePassword($newpass));
        echo 'Password change: ' . $newpass;
        return ldap_mod_replace($this->conn, $this->GetUserDnByUsername($username), $attr);
    }
    
    
    protected function EncodePassword($pw) {
        $newpw = '';
        $pw = "\"" . $pw . "\"";
        $len = strlen($pw);
        for ($i = 0; $i < $len; $i++) {
            $newpw .= "{$pw{$i}}\000";
        }
        $newpw = base64_encode($newpw);
        return $newpw;
    }
    
    
    public function UserSearch($username = '*')
    {
        $filter = '(&(objectCategory=person)(objectClass=user)';
        
        if (strpos($username, "@")) {
            $filter .= '(userPrincipalName=' . $username . ')';
        } else {
            $filter .= '(sAMAccountName=' . $username . ')';
        }
        $filter .= ')';
        $fields = array( 'samaccountname', 'cn', 'mail', 'memberof', 'primarygroupid', 'department', 'displayname', 'telephonenumber', 'primarygroupid', 'objectsid' );

        $sr = ldap_search($this->conn, $this->BaseDn, $filter, $fields);
        $entries = ldap_get_entries($this->conn, $sr);
        
        if(!$entries || $entries['count'] == 0) {
            return null;
        }
        
        //print_r($entries[0]['memberof']);
    
        $Users = array();
        for ($i = 0; $i < $entries['count']; $i++) {
            $UserInfo = array();
            $UserInfo['dn'] = $entries[$i]['dn'];
            foreach($fields as $field) {
                //$UserInfo['samaccountname'] = $entries[$i]['samaccountname'][0];
                if(array_key_exists($field, $entries[$i])) {
                    $UserInfo[$field] = $entries[$i][$field][0];
                }
            }
            
            // Get groups
            $UserInfo['memberof'] = array();
            if(array_key_exists('memberof', $entries[$i])) {
                for ($h = 0; $h < $entries[$i]['memberof']['count']; $h++) {
                    $UserInfo['memberof'][] = $this->UncustomizeAdminGroupName($this->GetGroupNameOnly($entries[$i]['memberof'][$h]));
                }
            }
            
            $Users[$i] = $UserInfo;
        }
        asort($Users);
        return $Users;
    }
    
    
    
    public function GroupRemUser($groupname, $username) {
        $attr = array('member' => $this->GetUserDnByUsername($username));
        return ldap_mod_del($this->conn, $this->GetGroupDnByCn($groupname), $attr);
    }
    
    public function GroupAddUser($groupname, $username) {
        $attr = array('member' => $this->GetUserDnByUsername($username));
        return ldap_mod_add($this->conn, $this->GetGroupDnByCn($groupname), $attr);
    }
    

    public function GroupSearch($search = '*')
    {
        $filter = '(&(objectCategory=group)';
        $filter .= '(cn=' . $search . '))';
        $fields = array('samaccountname','description');
        $sr = ldap_search($this->conn, $this->BaseDn, $filter, $fields);
        $entries = ldap_get_entries($this->conn, $sr);
        
        $groupsArray = array();
        for ($i = 0; $i < $entries['count']; $i ++) {
            $GroupName = $this->UncustomizeAdminGroupName($entries[$i]["samaccountname"][0]);
            if (strlen($entries[$i]['description'][0]) > 0) {
                $groupsArray[$GroupName] = $entries[$i]["description"][0];
            } else {
                $groupsArray[$GroupName] = $entries[$i]["samaccountname"][0];
            }
        }
        asort($groupsArray);
        return $groupsArray;
    }
    
    
    public function GroupExists($groupName) {
        return array_key_exists($this->UncustomizeAdminGroupName($groupName), $this->GroupSearch());
    }
    

    public function GroupAdd($groupName, $groupDescription, $attributes = array())
    {
        $attributes["cn"] = $this->CustomizeAdminGroupName($groupName);
        $attributes["samaccountname"] = $this->CustomizeAdminGroupName($groupName);
        $attributes["description"] = $groupDescription;
        $attributes["objectClass"] = array('group', 'top');
        return ldap_add($this->conn, $this->GetGroupDnByCn($groupName), $attributes);
    }

    
    public function GroupMod($groupName, $groupDescription, $attributes = array())
    {
        $attributes["description"] = $groupDescription;
        return ldap_mod_replace($this->conn, $this->GetGroupDnByCn($groupName), $attributes);
    }
    
    
    protected function GetUserDnByUsername($username) {
        $User = $this->UserGet($username);
        return $this->GetUserDnByCn($User['cn']);
    }
    
    
    protected function GetUserDnByCn($usercn) {
        return 'CN=' . $usercn . ',CN=Users,' . $this->BaseDn;
    }
    
    protected function GetGroupDnByCn($groupcn) {
        return 'CN=' . $this->CustomizeAdminGroupName($groupcn) . ',CN=Users,' . $this->BaseDn;
    }
    
    protected function GetGroupNameOnly($groupDn) {
        $res = explode(',', $groupDn)[0];
        if(strlen($res) > 3 && substr($res, 0, 3) == 'CN=') {
            $res = substr($res, 3, strlen($res) - 3);
        }
        return $res;
    }
    
    public function CustomizeAdminGroupName($name) {
        if(strcasecmp($name, 'Domain Admins') == 0 || strcasecmp($name, 'Admins. del dominio') == 0) {
            return $this->DomainAdminsGroupName;
        } else {
            return $name;
        }
    }
    
    
    public function UncustomizeAdminGroupName($name) {
        if(strcasecmp($name, $this->DomainAdminsGroupName) == 0) {
            return 'Domain Admins';
        } else {
            return $name;
        }
    }
    
    
}

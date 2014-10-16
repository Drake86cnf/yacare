<?php
namespace Yacare\MunirgBundle\Helper;

use Symfony\Component\DependencyInjection\ContainerInterface as Container;

class LdapHelper
{
    protected $ConnRg = null;
    protected $ConnMuni = null;

    public function __construct() {
        $this->ObtenerConexion();
    }
    
    public function __destruct() {
    }
    
    public function ObtenerConexion() {
        $this->ConnRg = new AdConnection('192.168.100.43', 'riogrande.local', 'Administrator', 'S1ni3sTr0');
        $this->ConnRg->Connect();
        
        $this->ConnMuni = new AdConnection('192.168.100.44', 'municipiorg.gob.ar', 'Administrador', 'S1ni3sTr0');
        $this->ConnMuni->DomainAdminsGroupName = 'Admins. del dominio';
        $this->ConnMuni->Connect();
    }

    public function CambiarContrasena($Agente) {
        $NombreUsuario = strtolower($Agente->getPersona()->getUsername());
        $Contrasena = $Agente->getPersona()->getPasswordEnc();
        //setlocale(LC_CTYPE, "en_US.UTF-8");
        exec("ssh root@corona 'sudo -u ebox changeadpw " . escapeshellarg($NombreUsuario) . " " . escapeshellarg($Contrasena) . "'");
        exec("winexe --interactive=0 -U MUNICIPIORG/Administrador%S1ni3sTr0 //192.168.100.44 \"net user " . addcslashes($NombreUsuario, '\\"') . " " . addcslashes($Contrasena, '\\"') . "\" > /dev/null 2>&1", $salida);
        //$this->ConnRg->UserSetPass($NombreUsuario, $Agente->getPersona()->getPasswordEnc());
    }
    
    
    function w32escapeshellarg($s)
    {
        return addcslashes($s, '\\"');
    }
    
    
    public function AgregarOActualizarAgente($Agente) {
        $NombreUsuario = strtolower($Agente->getPersona()->getUsername());
        
        $usuarionuevo = $this->ConnRg->UserGet($NombreUsuario);
        $usuarioviejo = $this->ConnMuni->UserGet($NombreUsuario);
        
        $AtributosGenerales = array(
            'sAMAccountName' => $NombreUsuario,
            'givenName' => $Agente->getPersona()->getNombre(),
            'sn' => $Agente->getPersona()->getApellido(),
            'displayName' => $Agente->getPersona()->getNombre() . ' ' . $Agente->getPersona()->getApellido(),
            'cn' => $Agente->getPersona()->getNombre() . ' ' . $Agente->getPersona()->getApellido(),
            'company' => 'Municipio de Río Grande',
            'l' => 'Río Grande',
            'st' => 'Tierra del Fuego',
            'postalCode' => '9420',
            'description' => 'Agente Municipal Legajo Nº ' . $Agente->getId(),
            'employeeNumber' => $Agente->getId(),
            'department' => $Agente->getDepartamento()->getNombre(),
            'userAccountControl' => $Agente->getSuprimido() ? 514 : 512
            
            /* 'change_password' => false,
            'enabled' => 1,
            'mail' => $Agente->getPersona()->getEmail(),
            'password' => $Agente->getPersona()->getPasswordEnc(), */
        );

        $AttrRg = array_merge($AtributosGenerales, array(
            'userPrincipalName' => $NombreUsuario . '@RIOGRANDE.LOCAL'
        ));
        
        if($usuarionuevo) {
            // Actualizar usuario en el dominio nuevo
            $this->ConnRg->UserMod($NombreUsuario, $AttrRg);
        } else {
            // Crear usuario en el dominio nuevo
            $this->ConnRg->UserAdd($NombreUsuario, $AttrRg);
        }
        
        $AttrMuni = array_merge($AtributosGenerales, array(
            'userPrincipalName' => $NombreUsuario . '@MUNICIPIORG.GOB.AR'
        ));
        
        if($usuarioviejo) {
            // Actualizar usuario en el dominio viejo
            $this->ConnMuni->UserMod($NombreUsuario, $AttrMuni);
        } else {
            // Crear usuario en el dominio viejo
            $this->ConnMuni->UserAdd($NombreUsuario, $AttrMuni);
        }
        
        $this->AjustarGrupos($this->ConnRg, $Agente);
        //$this->AjustarGrupos($this->ConnMuni, $Agente);
    }
    
    
    public function ObtenerGruposAnteriores($Agente) {
        $NombreUsuario = strtolower($Agente->getPersona()->getUsername());
        $Usuario = $this->ConnMuni->UserGet($NombreUsuario);
        $GruposUsuario = array();
        foreach($Usuario['memberof'] as $GrupoUsuario) {
            $GruposUsuario[] = $GrupoUsuario;
        }
        return $GruposUsuario;
    }
    
    
    /*
     * Agrega o quita al usuario de los grupos que corresponda
     */ 
    private function AjustarGrupos($Conn, $Agente) {
        $NombreUsuario = strtolower($Agente->getPersona()->getUsername());
        $Usuario = $Conn->UserGet($NombreUsuario);
        
        $GruposLdap = $Conn->GroupSearch();
        
        $GruposUsuario = array();
        foreach($Usuario['memberof'] as $GrupoUsuario) {
            $GruposUsuario[] = $GrupoUsuario;
        }
        
        $GruposAgente = array();
        foreach($Agente->getGrupos() as $GrupoAgente) {
            $GruposAgente[] = $GrupoAgente->getNombreLdap();
        }
        
        foreach($GruposAgente as $GrupoAgente) {
            if(in_array($GrupoAgente, $GruposUsuario) == false) {
                // Agrego al usuario al grupo
                if(array_key_exists($GrupoAgente, $GruposLdap)) {
                    // Siempre y cuando exista en el LDAP
                    $Conn->GroupAddUser($GrupoAgente, $NombreUsuario);
                }
            }
        }
        
        foreach($GruposUsuario as $GrupoUsuario) {
            if(in_array($GrupoUsuario, $GruposAgente) == false) {
                // Quitar al usuario de del grupo
                @$Conn->GroupRemUser($GrupoUsuario, $NombreUsuario);
            }
        }
    }
    
    /**
     * Crea o actualiza la descripción de un grupo.
     * @param AgenteGrupo $entity Un grupo de agentes, para replicar en LDAP.
     */
    public function AgregarOActualizarGrupo($entity) {
        $nombreLdap = $entity->getNombreLdap();
        if($nombreLdap) {
            if($this->ConnRg->GroupExists($nombreLdap) == false) {
                $this->ConnRg->GroupAdd($entity->getNombreLdap(), $entity->getNombre());
            } else {
                $this->ConnRg->GroupMod($entity->getNombreLdap(), $entity->getNombre());
            }
            
            if($this->ConnMuni->GroupExists($nombreLdap) == false) {
                $this->ConnMuni->GroupAdd($entity->getNombreLdap(), $entity->getNombre());
            } else {
                $this->ConnMuni->GroupMod($entity->getNombreLdap(), $entity->getNombre());
            }
        }
    }
}

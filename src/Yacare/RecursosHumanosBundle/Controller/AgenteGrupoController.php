<?php
namespace Yacare\RecursosHumanosBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Yacare\MunirgBundle\Helper\LdapHelper;

/**
 * Controlador de grupos de agentes.
 *
 * @Route("agentegrupo/")
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class AgenteGrupoController extends \Tapir\BaseBundle\Controller\AbmController
{
    use\Tapir\BaseBundle\Controller\ConEliminar;
    
    /**
     * @Route("volcar/")
     * @Template("YacareRecursosHumanosBundle:AgenteGrupo:listar.html.twig")
     */
    public function volcarAction(Request $request)
    {
        $res = parent::listarAction($request);
        
        $ldap = new \Yacare\MunirgBundle\Helper\LdapHelper();
        $grupos = $ldap->ObtenerGrupos();
        
        foreach ($res['entities'] as $entity) {
            $nombreLdap = $entity->getNombreLdap();
            if($nombreLdap) {
                if(in_array($nombreLdap, $grupos) == false) {
                    if($ldap->AgregarGrupo($entity) == false) {
                        echo " Error " . $nombreLdap;
                    }
                }
            }
        }
        
        $ldap = null;
        return $res;
    }
    
    
    /**
     * Reflejo los cambios en el servidor LDAP.
     */
    public function guardarActionPostPersist($entity, $editForm)
    {
        $nombreLdap = $entity->getNombreLdap();
        if($nombreLdap) {
            $ldap = new \Yacare\MunirgBundle\Helper\LdapHelper();
            $grupos = $ldap->ObtenerGrupos();
            if(in_array($nombreLdap, $grupos) == false) {
                $ldap->AgregarGrupo($entity);
            } else {
                $ldap->ModificarGrupo($entity);
            }
            $ldap = null;
        }
        
        return;
    }
}

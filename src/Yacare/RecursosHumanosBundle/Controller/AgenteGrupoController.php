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
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 *
 * @Route("agentegrupo/") 
 */
class AgenteGrupoController extends \Tapir\BaseBundle\Controller\AbmController
{
    use \Tapir\BaseBundle\Controller\ConEliminar;

    /**
     * @Route("volcar/")
     * @Template("YacareRecursosHumanosBundle:AgenteGrupo:listar.html.twig")
     */
    public function volcarAction(Request $request)
    {
        $this->Paginar = false;
        
        $res = parent::listarAction($request);
        
        $ldap = new \Yacare\MunirgBundle\Helper\LdapHelper($this->container);
        
        foreach ($res['entities'] as $entity) {
            $nombreLdap = $entity->getNombreLdap();
            if ($nombreLdap) {
                $ldap->AgregarOActualizarGrupo($entity);
            }
        }
        
        $ldap = null;
        
        return $res;
    }

/**
 * Reflejo los cambios en el servidor LDAP.
 */
    /*
     * public function guardarActionPostPersist($entity, $editForm)
     * {
     * $nombreLdap = $entity->getNombreLdap();
     * if ($nombreLdap) {
     * $ldap = new \Yacare\MunirgBundle\Helper\LdapHelper($this->container);
     * $ldap->AgregarOActualizarGrupo($entity);
     * $ldap = null;
     * }
     * return;
     * }
     */
}

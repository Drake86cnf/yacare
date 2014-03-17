<?php

namespace Yacare\MunirgBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Yacare\BaseBundle\Helper\StringHelper;
use Symfony\Component\HttpFoundation\StreamedResponse;


/**
 * @Route("ldap/")
 */
class LdapController extends Controller
{
    /**
     * @Route("importar/")
     * @Template("YacareMunirgBundle:Ldap:importar.html.twig")
     */
    public function importarAction(Request $request)
    {
        
    }
    
    
    /**
     * @Route("importar2/")
     * @Template("YacareMunirgBundle:Ldap:importar2.html.twig")
     */
    public function importar2Action(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $Dominio = 'municipiorg.gob.ar';
        $Usuario = $request->get('_username');
        $Contrasena = $request->get('_password');
        
        $ServidorAd = \ldap_connect($Dominio);
        \ldap_set_option($ServidorAd, LDAP_OPT_PROTOCOL_VERSION, 3);
        \ldap_set_option($ServidorAd, LDAP_OPT_REFERRALS, 0);
        $UsrBind = @\ldap_bind($ServidorAd, $Usuario . '@' . $Dominio, $Contrasena);
        if ($UsrBind) {
            //$fields = array("samaccountname","mail","memberof","department","displayname","telephonenumber","primarygroupid");
            $sr = \ldap_search($ServidorAd, "dc=municipiorg,dc=gob,dc=ar", "samaccountname=" . $Usuario);
            $info = \ldap_get_entries($ServidorAd, $sr);
            
            if(!$info || $info['count'] != 1) {
                $this->get('session')->getFlashBag()->add('warning', 'No se puede encontrar el usuario LDAP.');
                $this->redirect($this->generateUrl('yacare_munirg_ldap_importar'));
            }
            
            $AgenteLegajo = $info[0]['employeenumber'][0];
            
            if(!$AgenteLegajo) {
                $this->get('session')->getFlashBag()->add('warning', 'El usuario LDAP no tiene asignado un número de legajo.');
                $this->redirect($this->generateUrl('yacare_munirg_ldap_importar'));
            }
            
            $Agente = $em->getRepository('YacareRecursosHumanosBundle:Agente')->find($AgenteLegajo);
            if(!$Agente) {
                $this->get('session')->getFlashBag()->add('warning', 'No existe ningún agente con legajo Nº ' . $AgenteLegajo);
                $this->redirect($this->generateUrl('yacare_munirg_ldap_importar'));
            }
            
            $Persona = $Agente->getPersona();
            
            // Actualizo sal, usuario, contraseña encodeada y contraseña hash
            $Persona->setSalt(md5(uniqid(null, true)));
            $Persona->setUsername($Usuario);
            $Persona->setPasswordEnc($Contrasena);
            $factory = $this->get('security.encoder_factory');
            $encoder = $factory->getEncoder($Persona);
            $ContrasenaEnc = $encoder->encodePassword($Contrasena, $Persona->getSalt());
            $Persona->setPassword($ContrasenaEnc);
            
            $em->persist($Persona);
            $em->flush();

            \ldap_unbind($ServidorAd);
            
            $this->get('session')->getFlashBag()->add('success', '<i class="fa fa-check fa-2x"></i> Se asoció la cuenta con el agente legajo Nº ' . $AgenteLegajo . ' y se importaron los datos del servidor LDAP. Por favor intente conectarse nuevamente.');
            return $this->redirect($this->generateUrl('login'));
        } else {
            $this->get('session')->getFlashBag()->add('warning', 'No se pudo conectar al servidor LDAP.');
            return $this->redirect($this->generateUrl('yacare_munirg_ldap_importar'));
        }
    }
}
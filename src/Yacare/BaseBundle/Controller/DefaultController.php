<?php
namespace Yacare\BaseBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Controlador predeterminado.
 *
 * Contiene funciones puntuales de página de bienvenida (inicio), login y
 * logout.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class DefaultController extends \Tapir\BaseBundle\Controller\DefaultController
{

    /**
     * @Route("inicio/")
     * @Template
     */
    public function inicioAction()
    {
        $res = parent::inicioAction();
        
        $em = $this->getEm();
        $UsuarioConectado = $this->get('security.token_storage')->getToken()->getUser();

        $res['requerimientos_pendientes'] = $em->getRepository('\Yacare\RequerimientosBundle\Entity\Requerimiento')->findPendientesPorEncargado($UsuarioConectado);
        $res['requerimientos_propios'] = $em->getRepository('\Yacare\RequerimientosBundle\Entity\Requerimiento')->findPendientesPorUsuario($UsuarioConectado);
        
        $res['pestanias'] = ObtenerPestanias();
        
        return $res;
    }
    
    
    public function ObtenerPestanias() {
        return new \Tapir\TemplateBundle\Tabs\TabSet(
            array(
                new \Tapir\TemplateBundle\Tabs\Tab('General', '#1', true),
                new \Tapir\TemplateBundle\Tabs\Tab('Datos personales', '#2'),
                new \Tapir\TemplateBundle\Tabs\Tab('Cargos', '#3'),
                new \Tapir\TemplateBundle\Tabs\Tab('Familiares', '#4', false, true),
            ));
    }
    
    
    /**
     * @Route("/accesodenegado")
     * @Template
     */
    public function accesodenegadoAction()
    {
        return array();
    }
}

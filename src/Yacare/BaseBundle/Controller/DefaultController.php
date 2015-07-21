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
        
        $res['pestanias'] = $this->ObtenerPestanias();
        
        return $res;
    }
    
    
    public function ObtenerPestanias() {
        return new \Tapir\TemplateBundle\Tabs\TabSet(
            array(
                new \Tapir\TemplateBundle\Tabs\Tab('General', 'http://www.riogrande.gob.ar', true),
                new \Tapir\TemplateBundle\Tabs\Tab('Datos personales', 'http://www.tierradelfuego.gob.ar'),
                new \Tapir\TemplateBundle\Tabs\Tab('Cargos', 'http://www.google.com.ar'),
                new \Tapir\TemplateBundle\Tabs\Tab('Familiares', 'http://www.yahoo.com.ar', false, true),
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

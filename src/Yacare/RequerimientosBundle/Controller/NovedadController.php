<?php
namespace Yacare\RequerimientosBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Controlador de novedades de requerimientos.
 * 
 * @Route("novedad/")
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class NovedadController extends \Tapir\BaseBundle\Controller\BaseController
{
    use \Yacare\RequerimientosBundle\Controller\ConMailer;
    
    /**
     * @Route("publicar")
     * @Method("POST")
     * @Template()
     */
    public function publicarAction(Request $request)
    {
        $em = $this->getEm();
    
        $NuevaNovedad = new \Yacare\RequerimientosBundle\Entity\Novedad();
    
        $editForm = $this->createForm(new \Yacare\RequerimientosBundle\Form\NovedadType(), $NuevaNovedad);
        $editForm->handleRequest($request);
        
        if ($editForm->isValid()) {
            $NuevaNovedad->setUsuarioNombre((string)$NuevaNovedad->getUsuario());
            $NuevaNovedad->setUsuarioEmail($NuevaNovedad->getUsuario()->getEmail());
            $NuevaNovedad->setAutomatica(0);
            
            $em->persist($NuevaNovedad);
            $em->flush();
            if ($NuevaNovedad->getPrivada() == 0) {
                $this->InformarNovedad($NuevaNovedad);
            }
            
            return $this->ArrastrarVariables($request, array('entity' => $NuevaNovedad));
        } else {
            $validator = $this->get('validator');
            $errores = $validator->validate($NuevaNovedad);
            
            //var_dump($errores);
            return $this->ArrastrarVariables($request, array(
                'form_novedad' => $editForm->createView(),
                'errores' => (string)$errores
            ));
        }
    }
}

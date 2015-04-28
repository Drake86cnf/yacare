<?php
namespace Yacare\RequerimientosBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("novedad/")
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class NovedadController extends \Tapir\BaseBundle\Controller\BaseController
{
    /**
     * @Route("publicar")
     * @Method("POST")
     * @Template()
     */
    public function publicarAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
    
        $NuevaNovedad = new \Yacare\RequerimientosBundle\Entity\Novedad();
    
        $editForm = $this->createForm(new \Yacare\RequerimientosBundle\Form\NovedadType(), $NuevaNovedad);
        $editForm->handleRequest($request);
        
        if ($editForm->isValid()) {
            $NuevaNovedad->setUsuarioNombre((string)$NuevaNovedad->getUsuario());
            $NuevaNovedad->setUsuarioEmail($NuevaNovedad->getUsuario()->getEmail());
            
            $em->persist($NuevaNovedad);
            $em->flush();
    
            return $this->ArrastrarVariables(array('entity' => $NuevaNovedad));
        } else {
            $validator = $this->get('validator');
            $errores = $validator->validate($NuevaNovedad);
            
            var_dump($errores);
            return $this->ArrastrarVariables(array(
                'form_novedad' => $editForm->createView(),
                'errores' => (string)$errores
            ));
        }
    }
}

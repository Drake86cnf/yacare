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
            if ($NuevaNovedad->getPrivada() == 1) {
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
    
    public function InformarNovedad($NuevaNovedad)
    {
        $mailUsuario = $NuevaNovedad->getUsuario()->getEmail();
    
        $contenido = $this->renderView('YacareRequerimientosBundle:Requerimiento/Mail:requerimiento_novedad.html.twig', array(
            'notas' => $NuevaNovedad->getNotas()));
    
        $documento = $this->container->getParameter('kernel.root_dir') . '/../docs/instalar.html';
        $documento = preg_replace("/app..../i", "", $documento);
    
        $mensaje = \Swift_Message::newInstance()->setSubject('Seguimiento de Requerimiento')
        ->setFrom(array('reclamosriograndetdf@gmail.com' => 'Yacaré - Desarrollo'))
        ->setTo($mailUsuario)
        ->setBody($contenido, 'text/html')
        ->attach(\Swift_Attachment::fromPath($documento));
    
        $this->get('mailer')->send($mensaje);
    }
}

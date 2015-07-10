<?php
namespace Yacare\RequerimientosBundle\Controller;

trait ConMailer
{
    /**
     * Agrega una novedad a un requerimiento y envía un mail al usuario si corresponde.
     */
    public function InformarNovedad($NuevaNovedad, 
        $VistaEmail = 'YacareRequerimientosBundle:Requerimiento/Mail:requerimiento_novedad.html.twig', $NumeroSeguimiento = null)
    {
        if ($NuevaNovedad->getUsuario()) {
            if ($NuevaNovedad->getUsuario()->getEmail()) {
                $this->EnviarNovedad($NuevaNovedad->getUsuario()->getEmail(), $NuevaNovedad->getNotas(), $VistaEmail);
            }
        } elseif ($NuevaNovedad->getUsuarioEmail()) {
            $this->EnviarNovedad($NuevaNovedad->getUsuarioEmail(), $NuevaNovedad->getNotas(), $VistaEmail, $NumeroSeguimiento);
        }
    }

    public function EnviarNovedad($EmailUsuario, $NovedadNotas, $VistaEmail, $NumeroSeguimiento = null)
    {
        $contenido = $this->renderView($VistaEmail, array(
            'numero_seguimiento' => $NumeroSeguimiento,
            'novedad_notas' => $NovedadNotas));
        //$documento = $this->getParameter('kernel.root_dir') . '/../docs/instalar.html';
        //$documento = preg_replace("/app..../i", "", $documento);
        
        $mensaje = \Swift_Message::newInstance()->setSubject('Seguimiento de Requerimiento')
            ->setFrom(array(
            'reclamosriograndetdf@gmail.com' => 'Yacaré - Desarrollo'))
            ->setTo($EmailUsuario)
            ->setBody($contenido, 'text/html');
        //->attach(\Swift_Attachment::fromPath($documento))
        
        
        $this->get('mailer')->send($mensaje);
    }
}
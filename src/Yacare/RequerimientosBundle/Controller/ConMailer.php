<?php
namespace Yacare\RequerimientosBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Agrega la capacidad de informar una novedad vía e-mail.
 *
 * @author Ezequiel Riquelme <rezequiel.tdf@gmail.com>
 */
trait ConMailer
{
    /**
     * Agrega una novedad a un requerimiento y envía un e-mail al usuario si corresponde.
     * 
     * @param \Yacare\RequerimientosBundle\Entity\Novedad $NuevaNovedad      novedad nueva en el reqeurimiento.
     * @param string                                      $VistaEmail        direción donde se aloja la plantilla del 
     *                                                                       e-mail. 
     * @param string                                      $NumeroSeguimiento compuesto por la ID del requerimiento, y 
     *                                                                       un token aleatorio.
     */
    protected function InformarNovedad(
        $NuevaNovedad, 
        $VistaEmail = 'YacareRequerimientosBundle:Requerimiento/Mail:requerimiento_novedad.html.twig', 
        $NumeroSeguimiento = null)
    {
        if (trim(get_class($NuevaNovedad), '\\') == 'Yacare\RequerimientosBundle\Entity\Novedad') {
            if ($NuevaNovedad->getRequerimiento()->getUsuario()) {
                if ($NuevaNovedad->getRequerimiento()
                    ->getUsuario()
                    ->getEmail()) {
                    $this->EnviarNovedad(
                        $NuevaNovedad->getRequerimiento()
                            ->getUsuario()
                            ->getEmail(), $NuevaNovedad->getNotas(), $VistaEmail);
                }
            } elseif ($NuevaNovedad->getRequerimiento()->getUsuarioEmail()) {
                $this->EnviarNovedad($NuevaNovedad->getRequerimiento()
                    ->getUsuarioEmail(), $NuevaNovedad->getNotas(), $VistaEmail, $NumeroSeguimiento);
            }
        } else {
            if ($NuevaNovedad->getUsuario()) {
                if ($NuevaNovedad->getUsuario()->getEmail()) {
                    $this->EnviarNovedad($NuevaNovedad->getUsuario()
                        ->getEmail(), null, $VistaEmail);
                }
            } elseif ($NuevaNovedad->getUsuarioEmail()) {
                $this->EnviarNovedad($NuevaNovedad->getUsuarioEmail(), null, $VistaEmail, $NumeroSeguimiento);
            }
        }
    }

    /**
     * Prepara el e-mail y lo envía.
     * 
     * @see ConMailer::InformarNovedad()
     * 
     * @param string $EmailUsuario      el e-mail del usuario propietario del requerimiento.
     * @param string $NovedadNotas      novedad nueva asociada al requerimiento.
     * @param string $VistaEmail        dirección donde se aloja la plantilla del e-mail.
     * @param string $NumeroSeguimiento compuesto por la ID del requerimiento, y un token aleatorio.
     */
    protected function EnviarNovedad($EmailUsuario, $NovedadNotas = null, $VistaEmail, $NumeroSeguimiento = null)
    {
        $contenido = $this->renderView($VistaEmail, 
            array('numero_seguimiento' => $NumeroSeguimiento, 'novedad_notas' => $NovedadNotas));
        
        $mensaje = \Swift_Message::newInstance()
            ->setSubject('Novedades de su solicitud')
            ->setFrom(array('reclamos@riogrande.gob.ar' => 'Municipio de Río Grande'))
            ->setTo($EmailUsuario)
            ->setBody($contenido, 'text/html');
        
        $this->get('mailer')->send($mensaje);
    }

    /**
     * @Route("prueba/")
     * @Template
     */
    public function pruebaAction(Request $request)
    {
        $contenido = $this->renderView('YacareRequerimientosBundle:Requerimiento/Mail:requerimiento_novedad.html.twig', 
            array('numero_seguimiento' => '1-4800', 'novedad_notas' => 'Esta es una novedad'));
        
        $mensaje = \Swift_Message::newInstance()
            ->setSubject('Novedades de su solicitud')
            ->setFrom(array('reclamos@riogrande.gob.ar' => 'Municipio de Río Grande'))
            ->setTo('ecarrea@riogrande.gob.ar')
            ->setBody($contenido, 'text/html');
        
        $this->get('mailer')->send($mensaje);
        
        return $this->render('YacareRequerimientosBundle:Requerimiento:prueba.html.twig', array());
        // return $this->ArrastrarVariables($request, array());
    }
}

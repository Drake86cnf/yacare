<?php
namespace Yacare\RequerimientosBundle\Controller;

use Symfony\Component\HttpFoundation\Request;

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
     * @param \Yacare\RequerimientosBundle\Entity\Novedad $entidad      novedad nueva en el reqeurimiento.
     * @param string                                      $vistaEmail        direción donde se aloja la plantilla del 
     *                                                                       e-mail. 
     * @param string                                      $numeroSeguimiento compuesto por la ID del requerimiento, y 
     *                                                                       un token aleatorio.
     */
    protected function InformarNovedad($request, $entidad, 
        $vistaEmail = 'YacareRequerimientosBundle:Requerimiento/Mail:requerimiento_novedad.html.twig')
    {
        if (trim(get_class($entidad), '\\') == 'Yacare\RequerimientosBundle\Entity\Novedad') {
            $Requerimiento = $entidad->getRequerimiento();
            $Novedad = $entidad;
        } else {
            $Requerimiento = $entidad;
            $Novedad = null;
        }
        if($Requerimiento->getEmailNotificaciones()) {
            $res = $this->ConstruirResultado(new \Tapir\AbmBundle\Helper\Resultados\ResultadoVerAction($this), $request);
            $res->Entidad = $Requerimiento;
            $res->Novedad = $Novedad;
           
            $ContenidoMensaje = $this->renderView($vistaEmail, array('res' => $res)); 
            
            $Destinatarios = array();
            if($Requerimiento->getEncargado() && $Requerimiento->getEncargado()->getEmail()) {
                $Destinatarios[$Requerimiento->getEncargado()->getEmail()] = $Requerimiento->getEncargado()->NombreAmigable();
            }
            if($Requerimiento->getUsuario() && $Requerimiento->getUsuario()->getEmail()) {
                $Destinatarios[$Requerimiento->getUsuario()->getEmail()] = $Requerimiento->getUsuario()->NombreAmigable();
            } else {
                if($Requerimiento->getUsuarioNombre()) {
                    $Destinatarios[$Requerimiento->getUsuarioNombre()] = $Requerimiento->getUsuarioEmail();
                } else {
                    $Destinatarios['Usuario anónimo'] = $Requerimiento->getUsuarioEmail();
                }
            }
            
            if(count($Destinatarios) > 0) {
                $Mensaje = \Swift_Message::newInstance()
                    ->setSubject('Novedades de su solicitud')
                    ->setFrom(array('reclamos@riogrande.gob.ar' => 'Municipio de Río Grande'))
                    ->setTo($Destinatarios)
                    ->setBody($ContenidoMensaje, 'text/html');
                $this->get('mailer')->send($Mensaje);
            }
        }
    }
}

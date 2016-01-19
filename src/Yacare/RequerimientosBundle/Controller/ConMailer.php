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
     * @param object $entidad      La novedad a notificar o el reqeurimiento.
     * @param string $vistaEmail   El nombre de la plantilla para el mensaje de e-mail. 
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
            $res = $this->ConstruirResultado(new \Tapir\AbmBundle\Helper\Resultados\ResultadoVerAction($this), $request);
            $res->Entidad = $Requerimiento;
            $res->Novedad = $Novedad;
            $ContenidoMensaje = $this->renderView($vistaEmail, array('res' => $res)); 
        
            $Mensaje = \Swift_Message::newInstance()
                ->setSubject('Novedades de la solicitud Nº ' . $Requerimiento->getSeguimientoNumero())
                ->setFrom(array('reclamos@riogrande.gob.ar' => 'Municipio de Río Grande'))
                ->setTo($Destinatarios)
                ->setBody(\Tapir\BaseBundle\Helper\StringHelper::ObtenerTextoCuerpoHtml($ContenidoMensaje))
                ->addPart($ContenidoMensaje, 'text/html');
            $this->get('mailer')->send($Mensaje);
        }
    }
}

<?php
namespace Yacare\RecursosHumanosBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Controlador de consultas de haberes.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 *        
 * @Route("haberes/")
 */
class HaberesController extends \Tapir\BaseBundle\Controller\BaseController
{

    /**
     * @Route("recibo/listar")
     * @Route("recibo/listar/{id}")
     * @Template()
     */
    public function recibolistarAction(Request $request, $id = null)
    {
        $em = $this->getDoctrine()->getManager();
        $connHaberes = $this->get('doctrine')->getConnection('haberes');
        
        if ($id) {
            $Persona = $em->getRepository('Yacare\BaseBundle\Entity\Persona')->find($id);
        } else {
            $Persona = $this->get('security.context')
                ->getToken()
                ->getUser();
        }
        
        $Agente = $em->getRepository('Yacare\RecursosHumanosBundle\Entity\Agente')->find($Persona->getAgenteId());
        
        $sql = "SELECT AMES, PERI, NETO, KTHA, KTFM, KTEX, KTDL FROM RESUMEN
                    WHERE CODIGO LIKE '% " . $Agente->getId() . "/%' AND NETO>0 
                    ORDER BY CODIGO, AMES DESC";
        $ConsultaRecibos = $connHaberes->prepare($sql);
        $ConsultaRecibos->execute();
        
        $res = array('persona' => $Persona,'agente' => $Agente,'recibos' => $ConsultaRecibos->fetchAll());
        
        return $this->ArrastrarVariables($request, $res);
    }

    /**
     * @Route("recibo/ver")
     * @Route("recibo/ver/{id}")
     * @Template()
     */
    public function verAction(Request $request, $id = null)
    {
        $em = $this->getDoctrine()->getManager();
        $connHaberes = $this->get('doctrine')->getConnection('haberes');
        
        $ames = $this->ObtenerVariable($request, 'ames');
        $peri = $this->ObtenerVariable($request, 'peri');
        
        if ($id) {
            $Persona = $em->getRepository('Yacare\BaseBundle\Entity\Persona')->find($id);
        } else {
            $Persona = $this->get('security.context')
                ->getToken()
                ->getUser();
        }
        
        $Agente = $em->getRepository('Yacare\RecursosHumanosBundle\Entity\Agente')->find($Persona->getAgenteId());
        
        $sql = "SELECT TIPO, MONTO, COHADE, DESCITM, VO FROM RLIQUID
                    WHERE CODIGO LIKE '% " .
             $Agente->getId() . "/%' AND AMES='$ames' AND PERI='$peri'
                        AND TIPO>0 AND INFORM='N' ORDER BY TIPO, ORDEN";
        $ConsultaRecibo = $connHaberes->prepare($sql);
        $ConsultaRecibo->execute();
        
        $res = array(
            'persona' => $Persona,
            'agente' => $Agente,
            'ames' => $ames,
            'peri' => $peri,
            'detalles' => $ConsultaRecibo->fetchAll());
        
        return $this->ArrastrarVariables($request, $res);
    }
}
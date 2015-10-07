<?php
namespace Yacare\InspeccionBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Controlador para talonario de actas.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 * 
 * @Route("actatalonario/")
 */
class ActaTalonarioController extends \Tapir\BaseBundle\Controller\AbmController
{
    /**
     * @Route("ajax_persona", name="ajax_persona")
     */
    public function ajaxPersonaAction(Request $request)
    {
        $value = $request->get('term');
        
        $em = $this->getDoctrine()->getEntityManager();
        $members = $em->getRepository('YacareBaseBundle:Persona')
            ->createQueryBuilder('o')
            ->where('o.NombreVisible = :nombrevisible')
            ->setParameter('nombrevisible', $value)
            ->getQuery()
            ->getResult();
        
        $json = array();
        foreach ($members as $member) {
            $json[] = array('label' => $member->getNombreVisible(), 'value' => $member->getId());
        }
        
        $response = new Response();
        $response->setContent(json_encode($json));
        
        return $response;
    }
}

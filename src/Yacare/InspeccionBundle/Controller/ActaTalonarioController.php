<?php
namespace Yacare\InspeccionBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Controlador para talonario de actas.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 * 
 * @Route("actatalonario/")
 */
class ActaTalonarioController extends \Tapir\AbmBundle\Controller\AbmController
{
    /**
     * @Route("ajax_persona", name="ajax_persona")
     */
    public function ajaxPersonaAction(\Symfony\Component\HttpFoundation\Request $request)
    {
        $value = $request->get('term');
        
        $em = $this->getEm();
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
        
        $response = new \Symfony\Component\HttpFoundation\Response();
        $response->setContent(json_encode($json));
        
        return $response;
    }
}

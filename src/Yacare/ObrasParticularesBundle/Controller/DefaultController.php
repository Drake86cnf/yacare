<?php
namespace Yacare\ObrasParticularesBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Controlador de inicio.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class DefaultController extends \Tapir\BaseBundle\Controller\DefaultController
{
    /**
     * @Route("inicio/")
     * @Template()
     */
    public function inicioAction(\Symfony\Component\HttpFoundation\Request $request)
    {
        $em = $this->getEm();
        $res = $this->ConstruirResultado(new \Tapir\AbmBundle\Helper\Resultados\ResultadoInicioAction($this), $request);

        $qb = $em->createQueryBuilder();
        $qb->select('COUNT(ao.id)');
        $qb->from('\Yacare\ObrasParticularesBundle\Entity\ActaObra','ao');
        $res->Contadores['ActaObra'] = $qb->getQuery()->getSingleScalarResult();
        
        $qb = $em->createQueryBuilder();
        $qb->select('COUNT(r.id)');
        $qb->from('\Yacare\ObrasParticularesBundle\Entity\Matriculado','r');
        $res->Contadores['Matriculado'] = $qb->getQuery()->getSingleScalarResult();
        
        $qb = $em->createQueryBuilder();
        $qb->select('COUNT(r.id)');
        $qb->from('\Yacare\ObrasParticularesBundle\Entity\EmpresaConstructora','r');
        $res->Contadores['EmpresaConstructora'] = $qb->getQuery()->getSingleScalarResult();
        
        $qb = $em->createQueryBuilder();
        $qb->select('COUNT(r.id)');
        $qb->from('\Yacare\ObrasParticularesBundle\Entity\TramiteCat','r');
        $res->Contadores['TramiteCat'] = $qb->getQuery()->getSingleScalarResult();
        
        $qb = $em->createQueryBuilder();
        $qb->select('COUNT(r.id)');
        $qb->from('\Yacare\ObrasParticularesBundle\Entity\TramitePlanos','r');
        $res->Contadores['TramitePlanos'] = $qb->getQuery()->getSingleScalarResult();
    
        return array('res' => $res);
    }
}

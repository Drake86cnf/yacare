<?php
namespace Yacare\RequerimientosBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * Repositorio de requerimientos.
 *
 * @author Ernesto Carrea <equistango@gmail.com>
 */
class RequerimientoRepository extends \Tapir\BaseBundle\Entity\TapirBaseRepository
{
    public function findPendientesPorEncargado($encargado)
    {
        $qb = $this->createQueryBuilder('u');
        $qb->where('u.Encargado = :encargado AND u.Estado<50')->setParameter('encargado', $encargado);
        
        return $qb->getQuery()->getResult();
    }
}
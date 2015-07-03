<?php
namespace Yacare\RequerimientosBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * Repositorio de categorías.
 *
 * @author Ernesto Carrea <equistango@gmail.com>
 */
class CategoriaRepository extends \Tapir\BaseBundle\Entity\TapirBaseRepository
{
    public function ObtenerQueryBuilderPublicas()
    {
        $qb = $this->createQueryBuilder('u');
        $qb->where('u.PermiteAnonimos = 1');
        
        return $qb;
    }
}
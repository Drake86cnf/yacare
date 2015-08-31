<?php
namespace Yacare\RequerimientosBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * Repositorio de requerimientos.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class RequerimientoRepository extends \Tapir\BaseBundle\Entity\TapirBaseRepository
{
    /**
     * Consulta todos los requerimientos pendientes (no terminados ni cancelados) para un encargado en particular.
     * 
     * @param \Yacare\BaseBundle\Entity\Persona $encargado
     */
    public function findPendientesPorEncargado($encargado)
    {
        $qb = $this->createQueryBuilder('u');
        $qb->where('u.Encargado = :encargado AND u.Estado<50')->setParameter('encargado', $encargado);
        
        return $qb->getQuery()->getResult();
    }

    /**
     * Consulta todos los requerimientos pendientes (no terminados ni cancelados) iniciados por un usuario en
     * particular.
     * 
     * @param \Yacare\BaseBundle\Entity\Persona $usuario
     */
    public function findPendientesPorUsuario($usuario)
    {
        $qb = $this->createQueryBuilder('u');
        $qb->where('u.Usuario = :usuario AND u.Estado<50')->setParameter('usuario', $usuario);
        
        return $qb->getQuery()->getResult();
    }
}

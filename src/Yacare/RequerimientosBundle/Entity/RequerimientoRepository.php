<?php
namespace Yacare\RequerimientosBundle\Entity;

/**
 * Repositorio de requerimientos.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class RequerimientoRepository extends \Tapir\BaseBundle\Entity\TapirBaseRepository
{
    /**
     * Consulta todos los requerimientos pendientes para el usuario (como encargado o como iniciante).
     *
     * @param \Yacare\BaseBundle\Entity\Persona $usuario
     */
    public function findMisRequerimientos($usuario)
    {
        $qb = $this->createQueryBuilder('u');
        $qb->where('(u.Encargado = :encargado OR u.Usuario = :usuario) AND u.Estado < 50')->setParameter('encargado', $usuario);
    
        return $qb->getQuery()->getResult();
    }
    
    
    /**
     * Consulta todos los requerimientos pendientes sin encargado.
     *
     * @param \Yacare\BaseBundle\Entity\Persona $usuario
     */
    public function findRequerimientosSinEncargado()
    {
        $qb = $this->createQueryBuilder('u');
        $qb->where('u.Encargado IS NULL AND u.Estado < 50')->setParameter();
    
        return $qb->getQuery()->getResult();
    }
    
    
    /**
     * Consulta todos los requerimientos pendientes (no terminados ni cancelados) para un encargado en particular.
     * 
     * @param \Yacare\BaseBundle\Entity\Persona $encargado
     */
    public function findPendientesPorEncargado($encargado)
    {
        $qb = $this->createQueryBuilder('u');
        $qb->where('u.Encargado = :encargado AND u.Estado < 50')->setParameter('encargado', $encargado);
        
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
        $qb->where('u.Usuario = :usuario AND u.Estado < 50')->setParameter('usuario', $usuario);
        
        return $qb->getQuery()->getResult();
    }
}

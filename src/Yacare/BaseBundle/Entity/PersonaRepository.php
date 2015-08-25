<?php
namespace Yacare\BaseBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * Repositorio de personas.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class PersonaRepository extends \Tapir\BaseBundle\Entity\TapirBaseRepository
{

    public function ObtenerPorRol($rol)
    {
        return $this->ObtenerQueryBuilderPorRol($rol)->getQuery()->getResult();
    }

    public function ObtenerQueryBuilderPorRol($rol)
    {
        return $this->getEntityManager()
            ->createQueryBuilder()
            ->select('u')
            ->from('YacareBaseBundle:Persona', 'u')
            ->innerJoin('u.UsuarioRoles', 'r')
            ->where('r.Codigo = :codigorol')
            ->setParameter('codigorol', $rol);
    }
}

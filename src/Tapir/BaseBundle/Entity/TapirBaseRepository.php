<?php

namespace Tapir\BaseBundle\Entity;

use Doctrine\ORM\EntityRepository;

class TapirBaseRepository extends EntityRepository
{
    public function createQueryBuilder($alias)
    {
        $res = parent::createQueryBuilder($alias);
        
        if(\Tapir\BaseBundle\Helper\ClassHelper::UsaTrait($this->_entityName, 'Tapir\BaseBundle\Entity\ConNombre')) {
            $res->addOrderBy($alias . '.Nombre');
        }
        
        if(\Tapir\BaseBundle\Helper\ClassHelper::UsaTrait($this->_entityName, 'Tapir\BaseBundle\Entity\Suprimible')) {
            $res->where($alias . '.Suprimido=0');
        }
        
        if(\Tapir\BaseBundle\Helper\ClassHelper::UsaTrait($this->_entityName, 'Tapir\BaseBundle\Entity\Archivable')) {
            $dql = $res->getDql();
            if(strpos($dql, $alias . '.Archivado=1') === false) {
                // Sólo incluyo el filtro Archivado=0 si no existe un filtro explícito de Archivado=1
                $res->where($alias . '.Archivado=0');
            }
        }
        
        return $res;
    }
}
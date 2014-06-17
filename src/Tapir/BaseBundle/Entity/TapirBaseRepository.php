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
        
        return $res;
    }
}
<?php

namespace Yacare\BaseBundle\Entity;

use Doctrine\ORM\EntityRepository;

class YacareBaseRepository extends EntityRepository
{
    public function createQueryBuilder($alias)
    {
        $res = parent::createQueryBuilder($alias);
        
        if(\Yacare\BaseBundle\Helper\ClassHelper::UsaTrait($this->_entityName, 'Yacare\BaseBundle\Entity\ConNombre')) {
            $res->addOrderBy($alias . '.Nombre');
        }
        
        if(\Yacare\BaseBundle\Helper\ClassHelper::UsaTrait($this->_entityName, 'Yacare\BaseBundle\Entity\Suprimible')) {
            $res->where($alias . '.Suprimido=0');
        }
        
        return $res;
    }
}
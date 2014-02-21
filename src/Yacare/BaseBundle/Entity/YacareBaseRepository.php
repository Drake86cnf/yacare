<?php

namespace Yacare\BaseBundle\Entity;

use Doctrine\ORM\EntityRepository;

class YacareBaseRepository extends EntityRepository
{
    public function createQueryBuilder($alias)
    {
        $res = parent::createQueryBuilder($alias);
        
        if(in_array('Yacare\BaseBundle\Entity\ConNombre', class_uses($this->_entityName))) {
            $res->addOrderBy($alias . '.Nombre');
        }
        
        if(in_array('Yacare\BaseBundle\Entity\Suprimible', class_uses($this->_entityName))) {
            $res->where($alias . '.Suprimido=0');
        }
        
        return $res;
    }
}
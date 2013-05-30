<?php

namespace Yacare\BaseBundle\Entity;

use Doctrine\ORM\EntityRepository;

class BaseRepository extends EntityRepository
{
    function __construct() {
        if(strlen($this->BundleName) > 6 && substr($this->BundleName, -6) == 'Bundle')
                // Quitar la palabra 'Bundle' del nombre del bundle
                $this->BundleName = substr($this->BundleName, 0, strlen($this->BundleName) - 6);
        
        if(!isset($this->OrderBy))
            $this->OrderBy = null;
        
        if(!isset($this->Where))
            $this->Where = null;
    }

    public function find($id)
    {
        $dql = "SELECT r FROM Yacare" . $this->BundleName . "Bundle:" . $this->EntityName . " r WHERE r.Eliminado=0";
        
        $where = "";
        if(in_array('Yacare\BaseBundle\Entity\Eliminable', class_uses('Yacare\\' . $this->BundleName . 'Bundle\Entity\\' . $this->EntityName))) {
            $where = "r.Eliminado=0";
        } else {
            $where = "1=1";
        }
        
        $dql .= " WHERE $where";
        if($this->Where) {
            $this->Where = trim($this->Where);
            if(substr($this->Where, 0, 4) != "AND ")
                    $this->Where = "AND " . $this->Where;
            $dql .= ' ' . $this->Where;
        }

        if($this->OrderBy)
            $dql .= " ORDER BY " . $this->OrderBy;
        
        return $this->getEntityManager()
            ->createQuery($dql)
            ->getResult();
    }
}
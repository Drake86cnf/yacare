<?php

namespace Yacare\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yacare\BaseBundle\Entity\Comentario
 *
 * @ORM\Table(name="Base_Comentario")
 * @ORM\Entity
 */
class Comentario
{
    use \Yacare\BaseBundle\Entity\ConId;
    use \Yacare\BaseBundle\Entity\ConObs;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
    
    /**
     * @var $EntidadTipo
     * @ORM\Column(type="string", length=255)
     */
    private $EntidadTipo;

    /**
     * @var $EntidadId
     * @ORM\Column(type="integer")
     */
    private $EntidadId;


    public function getEntidadTipo() {
        return $this->EntidadTipo;
    }

    public function setEntidadTipo($EntidadTipo) {
        $this->EntidadTipo = $EntidadTipo;
    }

    public function getEntidadId() {
        return $this->EntidadId;
    }

    public function setEntidadId($EntidadId) {
        $this->EntidadId = $EntidadId;
    }
}
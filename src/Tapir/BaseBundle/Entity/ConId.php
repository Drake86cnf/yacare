<?php

namespace Tapir\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Tapir\BaseBundle\Helper\Damm;

/**
 * Trait que agrega la columna "id" a una entidad. Los métodos (getter y setter)
 * están en un trait separado.
 * 
 * @see ConIdMetodos
 *
 * @author Ernesto Carrea <equistango@gmail.com>
 */
trait ConId
{
    use \Tapir\BaseBundle\Entity\ConIdMetodos;
    
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
}


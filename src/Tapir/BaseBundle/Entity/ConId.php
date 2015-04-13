<?php
namespace Tapir\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Tapir\BaseBundle\Helper\Damm;

/**
 * Agrega la columna "id" a una entidad.
 *
 * Los métodos (getter y setter) están en un trait separado.
 *
 * @see ConIdMetodos
 *
 * @author Ernesto Carrea <equistango@gmail.com>
 */
trait ConId
{
    use \Tapir\BaseBundle\Entity\ConIdMetodos;

    /**
     * La clave primaria.
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
}


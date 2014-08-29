<?php
namespace Tapir\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait que agrega la capacidad de eliminar una entidad.
 *
 * La eliminación es permanente (se traduce en un DELETE SQL).
 *
 * @see Suprimible
 *
 * @author Ernesto Carrea <equistango@gmail.com>
 */
trait Eliminable
{
}

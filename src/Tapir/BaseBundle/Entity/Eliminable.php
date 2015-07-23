<?php
namespace Tapir\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Agrega la capacidad de eliminar una entidad.
 *
 * La eliminación es permanente (se traduce en un DELETE SQL).
 *
 * @see Suprimible
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
trait Eliminable
{
/**
 * Este trait no contiene funcionalidad implementada.
 *
 * El AmbController y otros controladores observan la presencia de este trait
 * para saber si la entidad puede ser eliminada y presentar las vistas
 * y acciones correspondientes.
 */
}

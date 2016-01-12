<?php
namespace Yacare\NominaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Un dispositivo genérico.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 *
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 * @ORM\Table(name="Nomina_DispositivoGenerico")
 */
class DispositivoGenerico extends \Yacare\NominaBundle\Entity\Dispositivo
{
}

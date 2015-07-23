<?php
namespace Yacare\TramitesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Representa un comprobante simple.
 *
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 * @ORM\Table(name="Tramites_ComprobanteSimple")
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
abstract class ComprobanteSimple extends Comprobante
{
}

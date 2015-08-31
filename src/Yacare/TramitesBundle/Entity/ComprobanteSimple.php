<?php
namespace Yacare\TramitesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Representa un comprobante simple.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 * 
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 * @ORM\Table(name="Tramites_ComprobanteSimple")
 */
abstract class ComprobanteSimple extends Comprobante
{
}

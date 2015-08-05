<?php
namespace Yacare\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Un dispositivo genérico.
 *
 * @ORM\Table(name="Base_DispositivoGenerico")
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 */
class DispositivoGenerico extends \Yacare\BaseBundle\Entity\Dispositivo
{
}
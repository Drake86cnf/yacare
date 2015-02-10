<?php

namespace Yacare\RecursosHumanosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Representa un resumen de la BD de haberes.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 *        
 * @ORM\Table(name="RESUMEN")
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 */
class HaberesResumen {
    /**
     * El 
     *
     *
     * @var $Funcion
     * @ORM\Column(type="string")
     */
    private $Funcion;
}
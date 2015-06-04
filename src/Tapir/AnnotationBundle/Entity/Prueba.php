<?php

namespace Tapir\AnnotationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Tapir\AnnotationBundle\Annotation\PruebaAnnotation;
use Tapir\AnnotationBundle\Annotation\AnotherValue;

/**
 * Prueba
 *
 * @ORM\Table(name="Annotation_Prueba")
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 */
class Prueba
{
	use \Tapir\BaseBundle\Entity\ConId;
	use \Tapir\BaseBundle\Entity\Suprimible;
	
	/**
	 * @PruebaAnnotation("nombre", dataType="string")
	 * @var unknown	
	 */	
    public function getNombre()
    {
    	return 'Ezequiel Riquelme';
    }
}
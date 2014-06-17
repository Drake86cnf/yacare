<?php

namespace Yacare\BromatologiaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yacare\BromatologiaBundle\Entity\ActaRutinaDecomiso
 *
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 * @ORM\Table(name="Bromatologia_ActaRutinaDecomiso")
 */
class ActaRutinaDecomiso extends \Yacare\BromatologiaBundle\Entity\ActaRutina
{
    use \Yacare\BromatologiaBundle\Entity\ConMercaderia;
    
    /**
     * @var integer
     * @ORM\Column(type="integer")
     */
    private $NotaNumero;
        
 
    public function getNotaNumero() {
        return $this->NotaNumero;
    }

    public function setNotaNumero($NotaNumero) {
        $this->NotaNumero = $NotaNumero;
    }
    
}

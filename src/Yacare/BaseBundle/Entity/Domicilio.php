<?php
namespace Yacare\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Un domicilio asociable a una Persona.
 *
 * @author Ernesto Carrea <equistango@gmail.com>
 *        
 *         @ORM\Table(name="Base_Persona_Domicilio")
 *         @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 */
class Domicilio
{
    use\Tapir\BaseBundle\Entity\ConId;
    use\Tapir\BaseBundle\Entity\Versionable;
    use\Tapir\BaseBundle\Entity\Suprimible;
    use\Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
    
    use\Yacare\BaseBundle\Entity\ConDomicilio;
    use\Yacare\CatastroBundle\Entity\ConPartida;

    /**
     * El tipo de domicilio.
     *
     * 1) El domicilio real de las personas, es el lugar donde tienen establecido el asiento principal de su residencia
     * y de sus negocios.
     * 2) El domicilio legal es el lugar donde la ley presume, sin admitir prueba en contra, que una persona reside de
     * una manera permanente para el ejercicio de sus derechos y cumplimiento de sus obligaciones, aunque de hecho no
     * esté allí presente.
     * 3) Domicilio comercial: Es el constituido por un comerciante para los efectos de las obligaciones emergentes de
     * sus actividades comerciales.
     *
     * 1 y 2 según Código Civil, Título VI, artículos 89 y 90.
     *
     * @var integer @ORM\Column(type="integer", nullable=false)
     */
    protected $Tipo;

    static public function TipoNombre($tipo)
    {
        switch ($tipo) {
            case 1:
                return 'real';
            case 2:
                return 'legal';
            case 3:
                return 'comercial';
            default:
                return 'Desconocido';
        }
    }

    public function getTipoNombre()
    {
        return Domicilio::TipoNombre($this->getTipo());
    }

    public function getTipo()
    {
        return $this->Tipo;
    }

    public function setTipo($Tipo)
    {
        $this->Tipo = $Tipo;
    }
}
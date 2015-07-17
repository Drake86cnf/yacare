<?php
namespace Yacare\RecursosHumanosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Un fammiliar de un agente en particular.
 *
 * @author Ezequiel Riquelme <rezequiel.tdf@gmail.com>
 *        
 *         @ORM\Table(name="Rrhh_Familiar")
 *         @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 */
class Familiar
{
    use \Tapir\BaseBundle\Entity\ConId;
    use \Tapir\BaseBundle\Entity\ConNombre;
    use \Tapir\BaseBundle\Entity\Suprimible;
    use \Tapir\BaseBundle\Entity\Versionable;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;

    /**
     * El/los apellido/s del familiar.
     *
     * @ORM\Column(type="string", length=100, nullable=false)
     */
    private $Apellido;

    /**
     * El número de documento.
     *
     * @ORM\Column(type="string", nullable=false)
     * @Assert\Length(max="10")
     */
    private $DocumentoNumero;

    /**
     * Sexo del familiar.
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $Sexo;

    /**
     * El parentesco.
     *
     * @ORM\Column(type="smallint", nullable=false)
     */
    private $Parentesco;

    /**
     * La fecha de nacimiento.
     *
     * @ORM\Column(type="date", nullable=false)
     * @Assert\Type("\DateTime")
     */
    private $FechaNacimiento;

    /**
     * Si es discapacitado, o no.
     *
     * @var unknown
     */
    private $Discapacitado;

    /**
     * La escolaridad.
     *
     * @var unknown
     */
    private $Escolaridad;

    /**
     * La residencia.
     *
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $Residencia;

    /**
     * La fecha de baja, o NULL si no se dió de baja.
     *
     * @ORM\Column(type="date", nullable=true)
     * @Assert\Type("\DateTime")
     */
    private $FechaBaja = null;

    /**
     * El motivo de la baja, 0 si está activo.
     *
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $MotivoBaja = 0;

    /**
     * Devuelve el nombre del parentesco.
     *
     * @see $Parentesco
     */
    public function getParentescoNombre()
    {
        return Familiar::setParentescosNombres($this->getParentesco());
    }

    public static function setParentescosNombres($rango)
    {
        switch ($rango) {
            case 0:
                return 'Madre';
            case 1:
                return 'Padre';
            case 2:
                return 'Madre fallecida';
            case 3:
                return 'Conyuge fallecido';
            case 4:
                return 'Hijo fallecido';
            case 5:
                return 'AC/Adoptado';
            case 6:
                return 'Nuera';
            case 7:
                return 'Nieto/a';
            case 8:
                return 'Hermano/a';
            case 9:
                return 'Primo/a';
            case 10:
                return 'Yerno';
            case 11:
                return 'Amigo/a';
            case 12:
                return 'Sobrino/a';
            case 13:
                return 'Hijastro/a';
            case 14:
                return 'Concubina/a';
            case 15:
                return 'Conyuge';
            case 16:
                return 'Hijo/a';
            default:
                return '';
        }
    }

    /**
     *
     * @ignore
     *
     */
    public function getApellido()
    {
        return $this->Apellido;
    }

    /**
     *
     * @ignore
     *
     */
    public function setApellido($Apellido)
    {
        $this->Apellido = $Apellido;
        return $this;
    }

    /**
     *
     * @ignore
     *
     */
    public function getSexo()
    {
        return $this->Sexo;
    }

    /**
     *
     * @ignore
     *
     */
    public function setSexo($Sexo)
    {
        $this->Sexo = $Sexo;
        return $this;
    }

    /**
     *
     * @ignore
     *
     */
    public function getParentesco()
    {
        return $this->Parentesco;
    }

    /**
     *
     * @ignore
     *
     */
    public function setParentesco($Parentesco)
    {
        $this->Parentesco = $Parentesco;
        return $this;
    }

    /**
     *
     * @ignore
     *
     */
    public function getFechaNacimiento()
    {
        return $this->FechaNacimiento;
    }

    /**
     *
     * @ignore
     *
     */
    public function setFechaNacimiento($FechaNacimiento)
    {
        $this->FechaNacimiento = $FechaNacimiento;
        return $this;
    }

    /**
     *
     * @ignore
     *
     */
    public function getDiscapacitado()
    {
        return $this->Discapacitado;
    }

    /**
     *
     * @ignore
     *
     */
    public function setDiscapacitado($Discapacitado)
    {
        $this->Discapacitado = $Discapacitado;
        return $this;
    }

    /**
     *
     * @ignore
     *
     */
    public function getEscolaridad()
    {
        return $this->Escolaridad;
    }

    /**
     *
     * @ignore
     *
     */
    public function setEscolaridad($Escolaridad)
    {
        $this->Escolaridad = $Escolaridad;
        return $this;
    }

    /**
     *
     * @ignore
     *
     */
    public function getResidencia()
    {
        return $this->Residencia;
    }

    /**
     *
     * @ignore
     *
     */
    public function setResidencia($Residencia)
    {
        $this->Residencia = $Residencia;
        return $this;
    }

    /**
     *
     * @ignore
     *
     */
    public function getFechaBaja()
    {
        return $this->FechaBaja;
    }

    /**
     *
     * @ignore
     *
     */
    public function setFechaBaja($FechaBaja)
    {
        $this->FechaBaja = $FechaBaja;
        return $this;
    }

    /**
     *
     * @ignore
     *
     */
    public function getMotivoBaja()
    {
        return $this->MotivoBaja;
    }

    /**
     *
     * @ignore
     *
     */
    public function setMotivoBaja($MotivoBaja)
    {
        $this->MotivoBaja = $MotivoBaja;
        return $this;
    }

    /**
     *
     * @ignore
     *
     */
    public function getDocumentoNumero()
    {
        return $this->DocumentoNumero;
    }

    /**
     *
     * @ignore
     *
     */
    public function setDocumentoNumero($DocumentoNumero)
    {
        $this->DocumentoNumero = str_replace(array(
            ',',
            '.',
            ' ',
            '-'), '', $DocumentoNumero);
        return $this;
    }
}
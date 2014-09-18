<?php

namespace Yacare\RecursosHumanosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Representa un agente (empleado).
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 *        
 * @ORM\Table(name="Rrhh_Agente", uniqueConstraints={@ORM\UniqueConstraint(name="ImportSrcId", columns={"ImportSrc", "ImportId"})})
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 */
class Agente {
	use \Tapir\BaseBundle\Entity\ConId;
	use \Tapir\BaseBundle\Entity\Versionable;
	use \Tapir\BaseBundle\Entity\Suprimible;
	use \Tapir\BaseBundle\Entity\Importable;
	use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
	
	/*
	 * CREATE VIEW rr_hh_agentes AS SELECT * FROM rr_hh.agentes; CREATE OR REPLACE VIEW yacare.Rrhh_Agente AS SELECT agentes.legajo AS id, agentes.fechaingre AS FechaIngreso, agentes.nombre AS NombreVisible, agentes.username, agentes.salt, agentes.password, agentes.is_active, agentes.NombreSolo as Nombre, agentes.Apellido, agentes.email FROM rr_hh.agentes; ALTER TABLE rr_hh.agentes ADD username VARCHAR(25) NOT NULL DEFAULT '', ADD salt VARCHAR(32) NOT NULL DEFAULT '', ADD password VARCHAR(40) NOT NULL DEFAULT '', ADD NombreSolo VARCHAR(255) NOT NULL DEFAULT '', ADD Apellido VARCHAR(255) NOT NULL DEFAULT '', CHANGE fechaingre fechaingre DATE NOT NULL, CHANGE nombre nombre VARCHAR(255) NOT NULL DEFAULT '', CHANGE email email VARCHAR(255) NOT NULL DEFAULT ''; UPDATE yacare.Rrhh_Agente SET salt=MD5(RAND()) WHERE salt=''; UPDATE rr_hh.agentes SET Apellido=TRIM(SUBSTRING_INDEX(nombre, ' ', 1)) WHERE NombreSolo=''; UPDATE rr_hh.agentes SET NombreSolo=TRIM(TRIM(LEADING Apellido FROM nombre)) WHERE NombreSolo='';
	 */
	
	/**
	 * La persona asociada.
	 *
	 * @ORM\ManyToOne(targetEntity="Yacare\BaseBundle\Entity\Persona")
	 * @ORM\JoinColumn(referencedColumnName="id", nullable=false)
	 */
	protected $Persona;
	
	/**
	 * La categoría actual.
	 *
	 * @var $Categoria @ORM\Column(type="integer", nullable=false)
	 */
	private $Categoria;
	
	/**
	 * TODO: Verificar el significado de este campo en "Gestion.exe" / con Daniel Camargo.
	 *
	 * @var $Situacion @ORM\Column(type="integer", nullable=false)
	 */
	private $Situacion;
	
	/**
	 * La función que cumple, en formato de texto libre.
	 *
	 *
	 * @var $Funcion @ORM\Column(type="string")
	 */
	private $Funcion;
	
	/**
	 * La fecha de ingreso.
	 *
	 * @ORM\Column(type="date", nullable=true)
	 * @Assert\Type("\DateTime")
	 */
	private $FechaIngreso;
	
	/**
	 * La fecha de baja, o NULL si todavía está activo.
	 *
	 * @ORM\Column(type="date", nullable=true)
	 * @Assert\Type("\DateTime")
	 */
	private $FechaBaja;
	
	
	/**
	 * El motivo de la baja, o 0 si está activo.
	 *
	 * @ORM\Column(type="smallint")
	 */
	private $MotivoBaja;
	
	/**
	 * Nivel de estudios.
	 *
	 * @ORM\Column(type="smallint")
	 */
	private $EstudiosNivel;
	
	/**
	 * Título (refiere a los estudios).
	 *
	 * @ORM\Column(type="integer", nullable=true)
	 */
	private $EstudiosTitulo;
	
	
	/**
	 * El departamento en el cual se desempeña.
	 *
	 * @var $Departamento @ORM\ManyToOne(targetEntity="\Yacare\OrganizacionBundle\Entity\Departamento")
	 *      @ORM\JoinColumn(referencedColumnName="id", nullable=true)
	 */
	protected $Departamento;
	public function __toString() {
		return $this->getPersona ()->getNombreVisible ();
	}
	
	
	public static function SituacionesNombres($rango) {
		switch ($rango) {
			case 0 :
				return 'Normal';
			case 1 :
				return 'Licencia sin goce de haberes';
			case 2	 :
				return 'Baja';
			case 3 :
				return 'Adscripción a otros organismos';
			case 4 :
				return 'Largo tratamiento al 50%';
			case 5 :
				return 'Ad-honorem';
			case 6 :
				return 'Adscripción de otros organismos';
			case 7 :
				return 'Pasantía rentada';
			case 8 :
				return 'Pasantía no rentada';
			case 9 :
				return 'Largo tratamiento al 100%';
			case 10 :
				return 'Largo tratamiento sin goce de haberes';
			case 11 :
				return 'Haberes 95% pasividad';
			case 12 :
				return 'Gabinete';
			case 13 :
				return 'Suspensión';
			default :
				return '';
		}
	}
	
	/**
	 * Obtiene el nombre de la situación.
	 * @see $Situacion
	 */
	public function getSituacionNombre() {
		return Agente::SituacionesNombres ( $this->getSituacion () );
	}
	
	
	public static function MotivosBajasNombres($rango) {
	    switch ($rango) {
	        case 0 :
	            return 'n/a';
	        case 1 :
	            return 'Renuncia';
	        case 2	 :
	            return 'Cesantía';
	        case 3 :
	            return 'Rescinde contrato';
	        case 4 :
	            return 'Finalización de contrato';
	        case 5 :
	            return 'Jubilación';
	        case 6 :
	            return 'Retiro';
	        case 7 :
	            return 'Fallecimiento';
	        default :
	            return '';
	    }
	}
	
	/**
	 * Obtiene el nombre del motivo de baja.
	 * @see $MotivoBaja
	 */
	public function getMotivoBajaNombre() {
	    return Agente::MotivosBajasNombres ( $this->getMotivoBaja () );
	}
	
	
	public static function EstudiosNivelesNombres($rango) {
	    switch ($rango) {
	    	case 0 :
	    	    return 'Sin escolaridad';
	        case 1 :
	        	return 'Menor de 4 años';
        	case 2 :
        	    return 'Primaria';
    	    case 3 :
    	        return 'Secundaria';
	        case 4 :
	            return 'Discapacitado';
            case 5 :
                return 'Primaria / preescolar discapacitado';
            case 7 :
                return 'Secundario discapacitado';
            case 8 :
                return 'Preescolar';
            case 9 :
                return 'Terciario';
            case 10 :
                return 'Universitario';
            /**
             * TODO: la tabla "titulos" en la base de recursos tiene información sin sentidlo
             */
	        default :
	            return '';
	    }
	}
	
	/**
	 * Obtiene el nombre del nivel de estudios.
	 * @see $MotivoBaja
	 */
	public function getEstudiosNivelNombre() {
	    return Agente::EstudiosNivelesNombres ( $this->getEstudiosNivel () );
	}

    /**
     *
     * @ignore
     *
     */
    public function getPersona()
    {
        return $this->Persona;
    }

    /**
     *
     * @ignore
     *
     */
    public function setPersona($Persona)
    {
        $this->Persona = $Persona;
        return $this;
    }

    /**
     *
     * @ignore
     *
     */
    public function getCategoria()
    {
        return $this->Categoria;
    }

    /**
     *
     * @ignore
     *
     */
    public function setCategoria($Categoria)
    {
        $this->Categoria = $Categoria;
        return $this;
    }

    /**
     *
     * @ignore
     *
     */
    public function getSituacion()
    {
        return $this->Situacion;
    }

    /**
     *
     * @ignore
     *
     */
    public function setSituacion($Situacion)
    {
        $this->Situacion = $Situacion;
        return $this;
    }

    /**
     *
     * @ignore
     *
     */
    public function getFuncion()
    {
        return $this->Funcion;
    }

    /**
     *
     * @ignore
     *
     */
    public function setFuncion($Funcion)
    {
        $this->Funcion = $Funcion;
        return $this;
    }

    /**
     *
     * @ignore
     *
     */
    public function getFechaIngreso()
    {
        return $this->FechaIngreso;
    }

    /**
     *
     * @ignore
     *
     */
    public function setFechaIngreso($FechaIngreso)
    {
        $this->FechaIngreso = $FechaIngreso;
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
    public function getDepartamento()
    {
        return $this->Departamento;
    }

    /**
     *
     * @ignore
     *
     */
    public function setDepartamento($Departamento)
    {
        $this->Departamento = $Departamento;
        return $this;
    }

    /**
     *
     * @ignore
     *
     */
    public function getEstudiosNivel()
    {
        return $this->EstudiosNivel;
    }

    /**
     *
     * @ignore
     *
     */
    public function setEstudiosNivel($EstudiosNivel)
    {
        $this->EstudiosNivel = $EstudiosNivel;
        return $this;
    }

    /**
     *
     * @ignore
     *
     */
    public function getEstudiosTitulo()
    {
        return $this->EstudiosTitulo;
    }

    /**
     *
     * @ignore
     *
     */
    public function setEstudiosTitulo($EstudiosTitulo)
    {
        $this->EstudiosTitulo = $EstudiosTitulo;
        return $this;
    }
 
	
}

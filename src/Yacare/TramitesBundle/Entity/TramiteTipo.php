<?php
namespace Yacare\TramitesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tipo de trámite (representa una especie).
 *
 * Define los datos de un trámite y está asociado a uno o más requisitos.
 *
 * ¡Atención! No define una instancia de un trámite, sino una especie. Esto es,
 * no representa un trámite en curso, sino que define cómo "se hace" un trámite.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 *
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 * @ORM\Table(name="Tramites_TramiteTipo")
 */
class TramiteTipo implements ITramiteTipo
{
    use \Tapir\BaseBundle\Entity\ConId;
    use \Tapir\BaseBundle\Entity\ConNombre;
    use \Tapir\BaseBundle\Entity\ConObs;
    use \Tapir\BaseBundle\Entity\ConNotas;
    use \Tapir\BaseBundle\Entity\ConUrl;
    use \Tapir\BaseBundle\Entity\Versionable;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
    
    /**
     * El nombre de la clase (derivada de Tramite) con la cual instanciar los
     * trámites de este tipo.
     *
     * @var string 
     * 
     * @ORM\Column(type="string", nullable=true)
     */
    protected $Clase;
    
    /**
     * Los nombres de las etapas separados por coma, o null si el trámite no tiene etapas.
     *
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $Etapas;
    
    /**
     * El tipo de comprobante que se emite al finalizar un trámite de este tipo.
     *
     * @var \Yacare\TramitesBundle\Entity\ComprobanteTipo
     *
     * @ORM\ManyToOne(targetEntity="ComprobanteTipo")
     * @ORM\JoinColumn(nullable=true)
     */
    protected $ComprobanteTipo;
    
    /**
     * El formulario con el cual se inicia este trámite.
     *
     * @var \Yacare\TramitesBundle\Entity\Instrumento
     *
     * @ORM\ManyToOne(targetEntity="Instrumento")
     * @ORM\JoinColumn(nullable=true)
     */
    protected $Formulario;
    
    /**
     * Requisito hermanado a este tipo de trámite.
     *
     * Al crear o editar un tipo de trámite, se crea o actualiza un requisito
     * que lo refleja para poder usarlo como requisito en otros tipos de trámite.
     *
     * @var \Yacare\TramitesBundle\Entity\Requisito
     *
     * @ORM\ManyToOne(targetEntity="Requisito", cascade={ "persist" })
     * @ORM\JoinColumn(nullable=true)
     */
    protected $RequisitoEspejo;
    
    /**
     * Requisitos asociados.
     *
     * Los tipos de trámite deber requerir que se cumplan uno o más requisitos
     * para completarse.
     *
     * @var \Yacare\TramitesBundle\Entity\AsociacionRequisito
     *
     * @ORM\OneToMany(targetEntity="AsociacionRequisito", mappedBy="TramiteTipo")
     * @ORM\JoinTable(name="Tramites_TramiteTipo_Requisito",
     *     joinColumns={@ORM\JoinColumn(name="TramiteTipo_id", referencedColumnName="id")}
     * )
     */
    protected $AsociacionRequisitos;
    
    /**
     * Devuelve las etapas en orden, en un array.
     */
    public function ObtenerEtapasEnOrden() {
        // Las etapas fueron sanitizadas por el helper, y el orden es el que aparece, así que se devuelven directamente
        return explode(',', $this->getEtapas());
    }
    
    /**
     * Devuelve una lista de asociaciones de requisitos según la etapa. Se se llama sin argumentos devuelve todos los
     * requisitos, ordenados por etapa.
     * 
     * @param string $etapa
     * @return \Yacare\TramitesBundle\Entity\AsociacionRequisito[]
     */
    public function ObtenerRequisitosPorEtapa($etapa = null) {
        $res = array();
        $Reqs = $this->getAsociacionRequisitos();
        if($etapa == null) {
            foreach($this->ObtenerEtapasEnOrden() as $EtapaEnOrden) {
                foreach ($Reqs as $Asoc) {
                    if($Asoc->getEtapa() == $EtapaEnOrden) {
                        $res[] = $Asoc;
                    }
                }
            }
        } else {
            foreach ($Reqs as $Asoc) {
                if($Asoc->getEtapa() == $etapa) {
                    $res[] = $Asoc;
                }
            }
        }
        return $res;
    }
    
    /**
     * Devuelve una lista de asociaciones de requisitos según el tipo de requisito.
     * @param string $tipoRequisito
     * @return \Yacare\TramitesBundle\Entity\AsociacionRequisito[]
     */
    public function ObtenerRequisitosPorTipo($tipoRequisito) {
        $res = array();
        $Reqs = $this->getAsociacionRequisitos();
        foreach ($Reqs as $Asoc) {
            if($Asoc->getRequisito()->getTipo() == $tipoRequisito) {
                $res[] = $Asoc;
            }
        }
        return $res;
    }
    
    
    /**
     * Devuelve una lista plana (no jerárquica) de los requisitos de este trámite y todos los subtrámites.
     * @param string $tipoRequisito
     * @return \Yacare\TramitesBundle\Entity\AsociacionRequisito[]
     */
    public function ObtenerRequisitosLineales($tipoRequisito = null) {
        $res = array();
        $Asociaciones = $this->getAsociacionRequisitos();
        foreach ($Asociaciones as $Asoc) {
            $Requisito = $Asoc->getRequisito();
            if($tipoRequisito == null || $Requisito->getTipo() == $tipoRequisito) {
                $res[] = $Asoc;
            }
            if($Requisito->getTipo() == 'tra') {
                $Subtramite = $Requisito->getTramiteTipoEspejo();
                if($Subtramite) {
                    $OtrosReqs = $Subtramite->ObtenerRequisitosLineales($tipoRequisito);
                    $res = array_merge($res, $OtrosReqs);
                }
            }
        }
        

        return $res;
    }
    

    /**
     * @ignore
     */
    public function getClase()
    {
        return $this->Clase;
    }

    /**
     * @ignore
     */
    public function setClase($Clase)
    {
        $this->Clase = $Clase;
    }

    /**
     * @ignore
     */
    public function getFormulario()
    {
        return $this->Formulario;
    }

    /**
     * @ignore
     */
    public function setFormulario($Formulario)
    {
        $this->Formulario = $Formulario;
    }

    /**
     * @ignore
     */
    public function getAsociacionRequisitos()
    {
        return $this->AsociacionRequisitos;
    }

    /**
     * @ignore
     */
    public function setAsociacionRequisitos($AsociacionRequisitos)
    {
        $this->AsociacionRequisitos = $AsociacionRequisitos;
    }

    /**
     * @ignore
     */
    public function getRequisitoEspejo()
    {
        return $this->RequisitoEspejo;
    }

    /**
     * @ignore
     */
    public function setRequisitoEspejo($RequisitoEspejo)
    {
        $this->RequisitoEspejo = $RequisitoEspejo;
    }

    /**
     * @ignore
     */
    public function getComprobanteTipo()
    {
        return $this->ComprobanteTipo;
    }

    /**
     * @ignore
     */
    public function setComprobanteTipo($ComprobanteTipo)
    {
        $this->ComprobanteTipo = $ComprobanteTipo;
    }

    /**
     * @ignore
     */
    public function getEtapas()
    {
        return $this->Etapas;
    }

    /**
     * @ignore
     */
    public function setEtapas($Etapas)
    {
        $this->Etapas = $Etapas;
        return $this;
    }
 
}

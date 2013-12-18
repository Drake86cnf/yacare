<?php

namespace Yacare\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yacare\BaseBundle\Entity\Dispositivo
 *
 * @ORM\Table(name="Base_Dispositivo")
 * @ORM\Entity(repositoryClass="Yacare\BaseBundle\Entity\YacareBaseRepository")
 */
class Dispositivo
{
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
    use \Yacare\BaseBundle\Entity\Versionable;

    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * 
     */
    private $id;
    
    /**
     * @var string $Tipo
     * @ORM\Column(type="string", length=255)
     */
    protected $Tipo;
        
    /**
     * @var string $Marca
     * @ORM\Column(type="string", length=255)
     */
    protected $Marca;

    /**
     * @var string $Modelo
     * @ORM\Column(type="string", length=255)
     */
    protected $Modelo;
    
    /**
     * @var string $NumeroSerie
     * @ORM\Column(type="string", length=255)
     */
    protected $NumeroSerie;
    
    /**
     * @var string $IdentificadorUnico
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $IdentificadorUnico;
    
    /**
     * @var string $Comentario
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $Comentario;
    
    /**
     * @ORM\ManyToOne(targetEntity="Yacare\BaseBundle\Entity\Persona")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    protected $Encargado;

    /**
     * Get id
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
    
    public function getMarca() {
        return $this->Marca;
    }

    public function setMarca($Marca) {
        $this->Marca = $Marca;
    }

    public function getModelo() {
        return $this->Modelo;
    }

    public function setModelo($Modelo) {
        $this->Modelo = $Modelo;
    }

    public function getNumeroSerie() {
        return $this->NumeroSerie;
    }

    public function setNumeroSerie($NumeroSerie) {
        $this->NumeroSerie = $NumeroSerie;
    }

    public function getComentario() {
        return $this->Comentario;
    }

    public function setComentario($Comentario) {
        $this->Comentario = $Comentario;
    }

    public function getEncargado() {
        return $this->Encargado;
    }

    public function setEncargado($Encargado) {
        $this->Encargado = $Encargado;
    }
    public function getTipo() {
        return $this->Tipo;
    }

    public function setTipo($Tipo) {
        $this->Tipo = $Tipo;
    }
    public function getIdentificadorUnico() {
        return $this->IdentificadorUnico;
    }

    public function setIdentificadorUnico($IdentificadorUnico) {
        $this->IdentificadorUnico = $IdentificadorUnico;
    }
    
    public function __toString()
    {
        return trim(($this->getTipo() == 'Otro' ? '' : $this->getTipo()) . ' ' . $this->getMarca() . ' ' . $this->getModelo() . ' (serie ' . $this->getNumeroSerie() . ')');
    }
}

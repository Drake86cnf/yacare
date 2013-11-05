<?php

namespace Yacare\OrganizacionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Yacare\BaseBundle\Model\Tree;

/**
 * Yacare\OrganizacionBundle\Entity\Departamento
 *
 * @ORM\Table(name="Organizacion_Departamento", uniqueConstraints={@ORM\UniqueConstraint(name="ImportSrcId", columns={"ImportSrc", "ImportId"})})
 * @ORM\Entity
 */
class Departamento implements Tree\NodeInterface
{
    
    // Un departamento representa a cualquiera de las partes en las que se divide la administración pública
    // como ministerios, secretarías, subsecretarías, etc.
    
    use \Yacare\BaseBundle\Entity\ConId;
    use \Yacare\BaseBundle\Entity\ConNombre;
    use \Yacare\BaseBundle\Entity\Versionable;
    use \Yacare\BaseBundle\Entity\Suprimible;
    use \Yacare\BaseBundle\Entity\Importable;
    use \Yacare\BaseBundle\Model\Tree\Node;
    
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $Rango;
    
    /**
     * @ORM\ManyToOne(targetEntity="Departamento")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    private $ParentNode;
    
    public function getRangoNombre() {
        switch($this->getRango()) {
            case 1: return 'Ejecutivo';
            case 20: return 'Ministerio';
            case 30: return 'Secretaría';
            case 40: return 'Subsecretaría';
            case 50: return 'Dirección';
            case 60: return 'Subdirección';
        }
    }
    
    
    public function getSangria($sangria = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;') {
        return str_repeat($sangria, substr_count($this->getMaterializedPath(), '/') - 1);
    }
    
    
    public function getNombreConSangriaDeEspaciosDuros() {
        // Atención, son 'espacios duro'
        return $this->getSangria('   ') . $this->getNombre();
    }
    
    
    public function getRango() {
        return $this->Rango;
    }

    public function setRango($Rango) {
        $this->Rango = $Rango;
    }

    public function getOrden() {
        return $this->Orden;
    }

    public function setOrden($Orden) {
        $this->Orden = $Orden;
    }
}



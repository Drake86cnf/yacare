<?php

namespace Yacare\OrganizacionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yacare\OrganizacionBundle\Entity\Departamento
 *
 * @ORM\Table(name="Organizacion_Departamento", uniqueConstraints={@ORM\UniqueConstraint(name="ImportSrcId", columns={"ImportSrc", "ImportId"})})
 * @ORM\Entity
 */
class Departamento
{
    // Un departamento representa a cualquiera de las partes en las que se divide la administración pública
    // como ministerios, secretarías, subsecretarías, etc.
    
    use \Yacare\BaseBundle\Entity\Timestampable;
    use \Yacare\BaseBundle\Entity\Versionable;
    use \Yacare\BaseBundle\Entity\Eliminable;
    use \Yacare\BaseBundle\Entity\Importable;
    use \Yacare\BaseBundle\Entity\ConNombre;
    use \Knp\DoctrineBehaviors\Model\Tree\Node;

    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    public function getId()
    {
        return $this->id;
    }

    /**
     * @var string $Rango
     * @ORM\Column(type="integer", nullable=true)
     */
    private $Rango;

    /**
     * @var string $DependeDe
     * @ORM\ManyToOne(targetEntity="Departamento")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    private $DependeDe;

    
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
    
    public function getDependeDe() {
        return $this->DependeDe;
    }

    public function setDependeDe($DependeDe) {
        $this->DependeDe = $DependeDe;
    }
    
    public function getRango() {
        return $this->Rango;
    }

    public function setRango($Rango) {
        $this->Rango = $Rango;
    }
}

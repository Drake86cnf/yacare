<?php

namespace Yacare\OrganizacionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yacare\OrganizacionBundle\Entity\Departamento
 *
 * @ORM\Table(name="Organizacion_Departamento")
 * @ORM\Entity
 */
class Departamento
{
    // Un departamento representa a cualquiera de las partes en las que se divide la administración pública
    // como ministerios, secretarías, subsecretarías, etc.
    
    /* Importar secretarías
    INSERT INTO Organizacion_Departamento
        (Nombre, DependeDe_id, Eliminado, ImportSrc, ImportId, ImportedAt)
        SELECT detalle, 1, 0, 'rr_hh.secretarias', codigo, NOW() FROM rr_hh.secretarias
        WHERE codigo NOT IN (SELECT DISTINCT ImportId FROM yacare.Organizacion_Departamento WHERE ImportSrc='rr_hh.secretarias');
    
    INSERT INTO Organizacion_Departamento
        (Nombre, DependeDe_id, Eliminado, ImportSrc, ImportId, ImportedAt)
        SELECT detalle, (SELECT id FROM Organizacion_Departamento WHERE ImportSrc='rr_hh.secretarias' AND ImportId=rr_hh.direcciones.secretaria), 0, 'rr_hh.direcciones', CONCAT(secretaria, '.', direccion), NOW() FROM rr_hh.direcciones
        WHERE codigo NOT IN (SELECT DISTINCT ImportId FROM yacare.Organizacion_Departamento WHERE ImportSrc='rr_hh.direcciones');
    */
    
    use \Yacare\BaseBundle\Entity\Timestampable;
    use \Yacare\BaseBundle\Entity\Versionable;
    use \Yacare\BaseBundle\Entity\Eliminable;
    use \Yacare\BaseBundle\Entity\Importable;

    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $Nombre
     * @ORM\Column(name="Nombre", type="string", length=255)
     */
    private $Nombre;

    /**
     * @var string $DependeDe
     * @ORM\ManyToOne(targetEntity="Departamento")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    private $DependeDe;
    
    public function getId()
    {
        return $this->id;
    }

    public function setNombre($nombre)
    {
        $this->Nombre = $nombre;
    }

    public function getNombre()
    {
        return $this->Nombre;
    }
    
    public function getDependeDe() {
        return $this->DependeDe;
    }

    public function setDependeDe($DependeDe) {
        $this->DependeDe = $DependeDe;
    }
}

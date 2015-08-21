<?php
namespace Tapir\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Agrega una columna de nombre a una entidad y sus métodos (getter y setter).
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
trait ConNombre
{
    /**
     * El nombre de la entidad.
     *
     * El nombre suele ser una representación de texto de la entidad. Para
     * personas, calles o ciudades debe ser el nombre visible. Para otras
     * entidades puede ser una etiqueta o representación (ToString) de la
     * entidad, por ejemplo "Comprobante Nº 32".
     *
     * @ORM\Column(type="string", length=255, nullable=false)
     * Assert\NotBlank(message="Debe proporcionar un nombre.")
     */
    private $Nombre;

    /**
     *
     * @ignore
     *
     */
    public function __toString()
    {
        if (isset($this->Nombre)) {
            return $this->Nombre;
        } else {
            return '';
        }
    }

    /**
     *
     * @ignore
     *
     */
    public function getNombre()
    {
        return $this->Nombre;
    }

    /**
     *
     * @ignore
     *
     */
    public function setNombre($Nombre)
    {
        $this->Nombre = $Nombre;
    }
}

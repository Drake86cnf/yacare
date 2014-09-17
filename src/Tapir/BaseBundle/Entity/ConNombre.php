<?php
namespace Tapir\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Agrega una columna de nombre a una entidad y sus métodos (getter y setter).
 *
 * @author Ernesto Carrea <equistango@gmail.com>
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
     * @ORM\Column(type="string", length=255)
     */
    private $nombre;

    /**
     * @ignore
     */
    public function __toString()
    {
        if ($this->nombre)
            return $this->getNombre();
        else
            return '';
    }

    /**
     * @ignore
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @ignore
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }
}

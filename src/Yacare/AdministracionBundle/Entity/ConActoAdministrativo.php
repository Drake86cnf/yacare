<?php
namespace Yacare\AdministracionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Agrega la capacidad de estar vinculado a un acto administrativo.
 * 
 * Un acto administrativo puede ser un decreto o resolución del ejecutivo municipal, concejo deliberante, etc.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
trait ConActoAdministrativo
{
    /**
     * El número de acto administrativo asociado, en el formato DM-1234/2015.
     * 
     * @var string
     * 
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Regex(
     *     pattern="/^\s*(DM|RM|DC|RC|DJ|RJ|SI|SG|SF|SA|SO|SP|AD|OR)*(\-)*(\d{1,5})\/(19|20)(\d{2})\s*$/i",
     *     message="Debe escribir el número de acto administrativo en el formato DM-1234/2015, RC-321/2014, etc."
     * )
     */
    protected $ActoAdministrativoNumero;

    /**
     * Setter con sanitización.
     */
    public function setActoAdministrativoNumero($actoAdministrativoNumero)
    {
        if($actoAdministrativoNumero) {
            // Lo paso a mayúsculas y le agrego el guió si corresponde
            $actoAdministrativoNumero = trim(strtoupper($actoAdministrativoNumero));
            if(strpos($actoAdministrativoNumero, '-') === false) {
                $actoAdministrativoNumero = substr($actoAdministrativoNumero, 0, 2) . '-' . substr($actoAdministrativoNumero, 2);
            }
        }
    
        $this->ActoAdministrativoNumero = $actoAdministrativoNumero;
        return $this;
    }
    
    /**
     * @ignore
     */
    public function getActoAdministrativoNumero()
    {
        return $this->ActoAdministrativoNumero;
    }
}

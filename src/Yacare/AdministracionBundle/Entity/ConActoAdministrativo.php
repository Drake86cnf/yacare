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
     *     pattern="/^\s*(\w{1,4})([ |\-])*(\d{1,5})\/(19|20)(\d{2})\s*$/i",
     *     message="Debe escribir el número de acto administrativo en el formato DM-1234/2015, RC-321/2014, etc."
     * )
     */
    protected $ActoAdministrativoNumero;
    
    
    protected function SanitizarActoAdministrativo($actoAdministrativoNumero) {
        if($actoAdministrativoNumero) {
            // Lo paso a mayúsculas y le agrego el guió si corresponde
            return strtoupper(trim($actoAdministrativoNumero, "-. \t\n\r\0\x0B"));
        } else {
            return $actoAdministrativoNumero;
        }
    }
    

    /**
     * Setter con sanitización.
     */
    public function setActoAdministrativoNumero($actoAdministrativoNumero)
    {
        $this->ActoAdministrativoNumero = $this->SanitizarActoAdministrativo($actoAdministrativoNumero);
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

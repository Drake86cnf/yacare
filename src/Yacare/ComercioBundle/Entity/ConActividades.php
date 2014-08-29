<?php
namespace Yacare\ComercioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

trait ConActividades
{

    /**
     * @ORM\ManyToOne(targetEntity="Yacare\ComercioBundle\Entity\Actividad")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    protected $ActividadPrincipal;

    /**
     * @ORM\ManyToOne(targetEntity="Yacare\ComercioBundle\Entity\Actividad")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    protected $ActividadSecundaria;

    /**
     * @ORM\ManyToOne(targetEntity="Yacare\ComercioBundle\Entity\Actividad")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    protected $ActividadTerciaria;

    public function getRequiereDeyma()
    {
        $Activ1 = $this->getActividadPrincipal();
        $Activ2 = $this->getActividadSecundaria();
        $Activ3 = $this->getActividadTerciaria();
        
        return ($Activ1 != null && $Activ1->getRequiereDeyma()) || ($Activ2 != null && $Activ2->getRequiereDeyma()) || ($Activ3 != null && $Activ3->getRequiereDeyma());
    }

    public function getRequiereDbeh()
    {
        $Activ1 = $this->getActividadPrincipal();
        $Activ2 = $this->getActividadSecundaria();
        $Activ3 = $this->getActividadTerciaria();
        
        return ($Activ1 != null && $Activ1->getRequiereDbeh()) || ($Activ2 != null && $Activ2->getRequiereDbeh()) || ($Activ3 != null && $Activ3->getRequiereDbeh());
    }

    public function getRequiereInfEscolar()
    {
        $Activ1 = $this->getActividadPrincipal();
        $Activ2 = $this->getActividadSecundaria();
        $Activ3 = $this->getActividadTerciaria();
        
        return ($Activ1 != null && $Activ1->getRequiereDbeh()) || ($Activ2 != null && $Activ2->getRequiereDbeh()) || ($Activ3 != null && $Activ3->getRequiereDbeh());
    }

    public function getRequiereCamaraGrasa()
    {
        $Activ1 = $this->getActividadPrincipal();
        $Activ2 = $this->getActividadSecundaria();
        $Activ3 = $this->getActividadTerciaria();
        
        return ($Activ1 != null && $Activ1->getRequiereDbeh()) || ($Activ2 != null && $Activ2->getRequiereDbeh()) || ($Activ3 != null && $Activ3->getRequiereDbeh());
    }

    public function getRequiereCamaraBarro()
    {
        $Activ1 = $this->getActividadPrincipal();
        $Activ2 = $this->getActividadSecundaria();
        $Activ3 = $this->getActividadTerciaria();
        
        return ($Activ1 != null && $Activ1->getRequiereDbeh()) || ($Activ2 != null && $Activ2->getRequiereDbeh()) || ($Activ3 != null && $Activ3->getRequiereDbeh());
    }

    public function getActividadPrincipal()
    {
        return $this->ActividadPrincipal;
    }

    public function getActividadSecundaria()
    {
        return $this->ActividadSecundaria;
    }

    public function getActividadTerciaria()
    {
        return $this->ActividadTerciaria;
    }

    public function setActividadPrincipal($ActividadPrincipal)
    {
        $this->ActividadPrincipal = $ActividadPrincipal;
    }

    public function setActividadSecundaria($ActividadSecundaria)
    {
        $this->ActividadSecundaria = $ActividadSecundaria;
    }

    public function setActividadTerciaria($ActividadTerciaria)
    {
        $this->ActividadTerciaria = $ActividadTerciaria;
    }
}

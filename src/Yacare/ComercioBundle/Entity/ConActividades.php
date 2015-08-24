<?php
namespace Yacare\ComercioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

trait ConActividades
{
    /**
     * @ORM\ManyToOne(targetEntity="Yacare\ComercioBundle\Entity\Actividad")
     * @ORM\JoinColumn(referencedColumnName="id", nullable=false)
     *
     * @Symfony\Component\Validator\Constraints\NotNull(message="Debe seleccionar una actividad principal.")
     * @Symfony\Component\Validator\Constraints\NotBlank(message="Debe elegir una actividad primaria.")
     */
    protected $Actividad1;

    /**
     * @ORM\ManyToOne(targetEntity="Yacare\ComercioBundle\Entity\Actividad")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    protected $Actividad2;

    /**
     * @ORM\ManyToOne(targetEntity="Yacare\ComercioBundle\Entity\Actividad")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    protected $Actividad3;

    /**
     * @ORM\ManyToOne(targetEntity="Yacare\ComercioBundle\Entity\Actividad")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    protected $Actividad4;

    /**
     * @ORM\ManyToOne(targetEntity="Yacare\ComercioBundle\Entity\Actividad")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    protected $Actividad5;

    /**
     * @ORM\ManyToOne(targetEntity="Yacare\ComercioBundle\Entity\Actividad")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    protected $Actividad6;

    public function getRequiereDeyma()
    {
        $Activ1 = $this->getActividad1();
        $Activ2 = $this->getActividad2();
        $Activ3 = $this->getActividad3();
        $Activ4 = $this->getActividad4();
        $Activ5 = $this->getActividad5();
        $Activ6 = $this->getActividad6();
        
        return ($Activ1 != null && $Activ1->getRequiereDeyma()) || ($Activ2 != null && $Activ2->getRequiereDeyma()) ||
             ($Activ3 != null && $Activ3->getRequiereDeyma()) || ($Activ4 != null && $Activ4->getRequiereDeyma()) ||
             ($Activ5 != null && $Activ5->getRequiereDeyma()) || ($Activ6 != null && $Activ6->getRequiereDeyma());
    }

    public function getRequiereDbeh()
    {
        $Activ1 = $this->getActividad1();
        $Activ2 = $this->getActividad2();
        $Activ3 = $this->getActividad3();
        $Activ4 = $this->getActividad4();
        $Activ5 = $this->getActividad5();
        $Activ6 = $this->getActividad6();
        
        return ($Activ1 != null && $Activ1->getRequiereDbeh()) || ($Activ2 != null && $Activ2->getRequiereDbeh()) ||
             ($Activ3 != null && $Activ3->getRequiereDbeh()) || ($Activ4 != null && $Activ4->getRequiereDbeh()) ||
             ($Activ5 != null && $Activ5->getRequiereDbeh()) || ($Activ6 != null && $Activ6->getRequiereDbeh());
    }

    public function getRequiereInfEscolar()
    {
        $Activ1 = $this->getActividad1();
        $Activ2 = $this->getActividad2();
        $Activ3 = $this->getActividad3();
        $Activ4 = $this->getActividad4();
        $Activ5 = $this->getActividad5();
        $Activ6 = $this->getActividad6();
        
        return ($Activ1 != null && $Activ1->getRequiereInfEscolar()) ||
             ($Activ2 != null && $Activ2->getRequiereInfEscolar()) ||
             ($Activ3 != null && $Activ3->getRequiereInfEscolar()) ||
             ($Activ4 != null && $Activ4->getRequiereInfEscolar()) ||
             ($Activ5 != null && $Activ5->getRequiereInfEscolar()) ||
             ($Activ6 != null && $Activ6->getRequiereInfEscolar());
    }

    public function getRequiereCamaraGrasa()
    {
        $Activ1 = $this->getActividad1();
        $Activ2 = $this->getActividad2();
        $Activ3 = $this->getActividad3();
        $Activ4 = $this->getActividad4();
        $Activ5 = $this->getActividad5();
        $Activ6 = $this->getActividad6();
        
        return ($Activ1 != null && $Activ1->getRequiereCamaraGrasa()) ||
             ($Activ2 != null && $Activ2->getRequiereCamaraGrasa()) ||
             ($Activ3 != null && $Activ3->getRequiereCamaraGrasa()) ||
             ($Activ4 != null && $Activ4->getRequiereCamaraGrasa()) ||
             ($Activ5 != null && $Activ5->getRequiereCamaraGrasa()) ||
             ($Activ6 != null && $Activ6->getRequiereCamaraGrasa());
    }

    public function getRequiereCamaraBarro()
    {
        $Activ1 = $this->getActividad1();
        $Activ2 = $this->getActividad2();
        $Activ3 = $this->getActividad3();
        $Activ4 = $this->getActividad4();
        $Activ5 = $this->getActividad5();
        $Activ6 = $this->getActividad6();
        
        return ($Activ1 != null && $Activ1->getRequiereCamaraBarro()) ||
             ($Activ2 != null && $Activ2->getRequiereCamaraBarro()) ||
             ($Activ3 != null && $Activ3->getRequiereCamaraBarro()) ||
             ($Activ4 != null && $Activ4->getRequiereCamaraBarro()) ||
             ($Activ5 != null && $Activ5->getRequiereCamaraBarro()) ||
             ($Activ6 != null && $Activ6->getRequiereCamaraBarro());
    }

    public function getRequiereImpactoSonoro()
    {
        $Activ1 = $this->getActividad1();
        $Activ2 = $this->getActividad2();
        $Activ3 = $this->getActividad3();
        $Activ4 = $this->getActividad4();
        $Activ5 = $this->getActividad5();
        $Activ6 = $this->getActividad6();
        
        return ($Activ1 != null && $Activ1->getRequiereImpactoSonoro()) ||
             ($Activ2 != null && $Activ2->getRequiereImpactoSonoro()) ||
             ($Activ3 != null && $Activ3->getRequiereImpactoSonoro()) ||
             ($Activ4 != null && $Activ4->getRequiereImpactoSonoro()) ||
             ($Activ5 != null && $Activ5->getRequiereImpactoSonoro()) ||
             ($Activ6 != null && $Activ6->getRequiereImpactoSonoro());
    }

    /**
     *
     * @ignore
     *
     */
    public function getActividad1()
    {
        return $this->Actividad1;
    }

    /**
     *
     * @ignore
     *
     */
    public function setActividad1($Actividad1)
    {
        $this->Actividad1 = $Actividad1;
        return $this;
    }

    /**
     *
     * @ignore
     *
     */
    public function getActividad2()
    {
        return $this->Actividad2;
    }

    /**
     *
     * @ignore
     *
     */
    public function setActividad2($Actividad2)
    {
        $this->Actividad2 = $Actividad2;
        return $this;
    }

    /**
     *
     * @ignore
     *
     */
    public function getActividad3()
    {
        return $this->Actividad3;
    }

    /**
     *
     * @ignore
     *
     */
    public function setActividad3($Actividad3)
    {
        $this->Actividad3 = $Actividad3;
        return $this;
    }

    /**
     *
     * @ignore
     *
     */
    public function getActividad4()
    {
        return $this->Actividad4;
    }

    /**
     *
     * @ignore
     *
     */
    public function setActividad4($Actividad4)
    {
        $this->Actividad4 = $Actividad4;
        return $this;
    }

    /**
     *
     * @ignore
     *
     */
    public function getActividad5()
    {
        return $this->Actividad5;
    }

    /**
     *
     * @ignore
     *
     */
    public function setActividad5($Actividad5)
    {
        $this->Actividad5 = $Actividad5;
        return $this;
    }

    /**
     *
     * @ignore
     *
     */
    public function getActividad6()
    {
        return $this->Actividad6;
    }

    /**
     *
     * @ignore
     *
     */
    public function setActividad6($Actividad6)
    {
        $this->Actividad6 = $Actividad6;
        return $this;
    }
}
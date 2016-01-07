<?php
namespace Yacare\TramitesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ComprobanteTipoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Codigo', null, array('label' => 'Codigo'))
            ->add('Nombre', null, array('label' => 'Nombre'))
            ->add('Clase', null, array('label' => 'Clase'))
            ->add('PeriodoValidez', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType', array(
                'label' => 'Período de validez', 
                'required' => false, 
                'placeholder' => 'Sin vencimiento', 
                'choices' => array(
                    '1 día' => '1D', 
                    '2 días' => '2D', 
                    '3 días' => '3D', 
                    '7 días' => '7D', 
                    '14 días' => '14D', 
                    '30 días' => '30D', 
                    '60 días' => '60D', 
                    '90 días' => '90D', 
                    '120 días' => '120D', 
                    '1 mes' => '1M', 
                    '2 meses' => '2M', 
                    '3 meses' => '3M', 
                    '4 meses' => '4M', 
                    '5 meses' => '5M', 
                    '6 meses' => '6M', 
                    '1 año' => '1Y', 
                    '2 años' => '2Y', 
                    '3 años' => '3Y', 
                    '4 años' => '4Y', 
                    '5 años' => '5Y', 
                    '10 años' => '10Y', 
                    '15 años' => '15Y', 
                    '20 años' => '20Y')))
            ->add('Obs', null, array(
                'label' => 'Obs.', 
                'attr' => array('class' => 'tinymce', 'data-theme' => 'simple'))) // simple, advanced, bbcode
;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array('data_class' => 'Yacare\TramitesBundle\Entity\ComprobanteTipo'));
    }
}

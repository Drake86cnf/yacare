<?php
namespace Yacare\TramitesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ComprobanteTipoType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('Codigo', null, array('label' => 'Codigo'))
            ->add('Nombre', null, array('label' => 'Nombre'))
            ->add('Clase', null, array('label' => 'Clase'))
            ->add('PeriodoValidez', 'choice', 
            array(
                'label' => 'Período de validez',
                'required' => false,
                'placeholder' => 'Sin vencimiento',
                'choices' => array(
                    '1D' => '1 día',
                    '2D' => '2 días',
                    '3D' => '3 días',
                    '7D' => '7 días',
                    '14D' => '14 días',
                    '30D' => '30 días',
                    '60D' => '60 días',
                    '90D' => '90 días',
                    '120D' => '120 días',
                    '1M' => '1 mes',
                    '2M' => '2 meses',
                    '3M' => '3 meses',
                    '4M' => '4 meses',
                    '5M' => '5 meses',
                    '6M' => '6 meses',
                    '1Y' => '1 año',
                    '2Y' => '2 años',
                    '3Y' => '3 años',
                    '4Y' => '4 años',
                    '5Y' => '5 años',
                    '10Y' => '10 años',
                    '15Y' => '15 años',
                    '20Y' => '20 años')))
            ->add('Obs', null, 
            array(
                'label' => 'Obs.',
                'attr' => array('class' => 'tinymce','data-theme' => 'simple')) // simple, advanced, bbcode
);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array('data_class' => 'Yacare\TramitesBundle\Entity\ComprobanteTipo'));
    }

    public function getName()
    {
        return 'yacare_tramitesbundle_comprobantetipotype';
    }
}

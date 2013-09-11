<?php

namespace Yacare\BromatologiaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AnalisisType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder            
            ->add('ProtocoloNumero', null, array('label' => 'Protocolo Nº'))
            ->add('TipoAnalisis', null, array('label' => 'Tipo de Analisis'))                       
            ->add('ResultadoAnalisis', null, array('label' => 'Resultado'))
            ->add('Observaciones', null, array('label' => 'Observaciones'))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Yacare\BromatologiaBundle\Entity\Analisis'
        ));
    }

    public function getName()
    {
        return 'yacare_bromatologiabundle_analisis';
    }
}

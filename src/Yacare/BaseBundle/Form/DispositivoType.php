<?php

namespace Yacare\BaseBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DispositivoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Tipo', 'choice', array(
                'choices'   => array(
                    'Tableta' => 'Tableta',
                    'Teléfono celular' => 'Teléfono celular',
                    'Impresora' => 'Impresora',
                    'Localizador GPS personal' => 'Localizador GPS personal',
                    'Localizador GPS automóvil' => 'Localizador GPS automóvil',
                    'Otro' => 'Otro'
                    ),
                'required'  => true,
                'label' => 'Tipo'))
            ->add('Marca', null, array('label' => 'Marca'))
            ->add('Modelo', null, array('label' => 'Modelo'))
            ->add('NumeroSerie', null, array('label' => 'Identificador único'))
            ->add('Comentario', null, array('label' => 'Comentario'))
            ->add('Encargado', 'entity', array(
                'label' => 'Encargado',
                'class' => 'YacareRecursosHumanosBundle:Agente',
                'required' => true,
                'empty_value' => false,
                'property' => 'Persona.NombreVisible'))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Yacare\BaseBundle\Entity\Dispositivo'
        ));
    }

    public function getName()
    {
        return 'yacare_basebundle_dispositivotype';
    }
}

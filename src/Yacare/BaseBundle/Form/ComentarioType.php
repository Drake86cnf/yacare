<?php

namespace Yacare\BaseBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ComentarioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Obs', 'textarea', array('label' => 'Comentario'))
            ->add('et', 'hidden', array(
                'data' => 'abcdef',
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Yacare\BaseBundle\Entity\Comentario'
        ));
    }

    public function getName()
    {
        return 'yacare_basebundle_comentariotype';
    }
}

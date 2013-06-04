<?php

namespace Yacare\OrganizacionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DependenciaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Nombre', null, array('label' => 'Nombre',))
            ->add('Parent', 'entity', array('label' => 'Depende de ',
                'class' => 'YacareBaseBundle:Dependencia',
                'required' => true,
                'empty_value' => false,
                'property' => 'Nombre'))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Yacare\BaseBundle\Entity\Dependencia'
        ));
    }

    public function getName()
    {
        return 'yacare_basebundle_dependenciatype';
    }
}

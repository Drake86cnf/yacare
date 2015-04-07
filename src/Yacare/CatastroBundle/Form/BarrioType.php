<?php
namespace Yacare\CatastroBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BarrioType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('Nombre', null, array(
                'label' => 'Nombre'
            ))
            ->add('NombreOriginal', null, array(
                'label' => 'Nombre original'
            ))
            ->add('Obs', null, array(
                'label' => 'Obs.'
            ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Yacare\CatastroBundle\Entity\Barrio'
        ));
    }

    public function getName()
    {
        return 'yacare_catastrobundle_barriotype';
    }
}

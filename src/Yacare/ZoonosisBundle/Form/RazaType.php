<?php
namespace Yacare\ZoonosisBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RazaType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('Nombre', null, array(
            'label' => 'Nombre'
        ))->add('TipoAnimal', 'choice', array(
            'choices' => array(
                '1' => 'Perro',
                '2' => 'Gato',
                '3' => 'Caballo'
            ),
            'required' => true,
            'label' => 'Tipo'
        ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Yacare\ZoonosisBundle\Entity\Raza'
        ));
    }

    public function getName()
    {
        return 'yacare_zoonosisbundle_razatype';
    }
}

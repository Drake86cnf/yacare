<?php
namespace Yacare\ZoonosisBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AtaqueType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('Mascota', null, array(
            'label' => 'Mascota'
        ))
            ->add('Aquien', 'choice', array(
            'choices' => array(
                '1' => 'Persona',
                '2' => 'Mascota'
            ),
            'required' => true,
            'label' => 'A quien'
        ))
            ->add('FechaAtaque', 'date', array(
            'years' => range(1900, 2099),
            'widget' => 'single_text',
            'label' => 'Fecha del ataque'
        ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Yacare\ZoonosisBundle\Entity\Ataque'
        ));
    }

    public function getName()
    {
        return 'yacare_zoonosisbundle_ataquetype';
    }
}

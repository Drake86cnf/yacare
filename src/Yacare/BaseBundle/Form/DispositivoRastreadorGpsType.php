<?php
namespace Yacare\BaseBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DispositivoRastreadorGpsType extends DispositivoType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        
        $builder->add('TelefonoNumero', null, array(
            'label' => 'Nº de línea'
        ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Yacare\BaseBundle\Entity\DispositivoRastreadorGps'
        ));
    }

    public function getName()
    {
        return 'yacare_basebundle_dispositivorastreadorgpstype';
    }
}

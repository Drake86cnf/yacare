<?php
namespace Yacare\SeguridadBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CamaraType extends \Yacare\BaseBundle\Form\DispositivoType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        
        $builder->add('CamaraTipo', 'choice', array(
            'choices' => array(
                'Fija' => 'Fija',
                'Domo' => 'Domo',
                'Otro' => 'Otro'
            ),
            'required' => true,
            'label' => 'Tipo'
        ))
            ->add('Ubicacion', null, array(
            'label' => 'Ubicación'
        ))
            ->add('LoginContrasena', 'password', array(
            'label' => 'Contraseña',
            'required' => false,
            'always_empty' => false
        ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Yacare\SeguridadBundle\Entity\Camara'
        ));
    }

    public function getName()
    {
        return 'yacare_seguridadbundle_camaratype';
    }
}

<?php
namespace Yacare\BaseBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

abstract class DispositivoType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('Marca', null, array(
            'label' => 'Marca'
        ))
        ->add('Modelo', null, array(
            'label' => 'Modelo'
        ))
        ->add('NumeroSerie', null, array(
            'label' => 'Número de serie'
        ))
        ->add('IdentificadorUnico', null, array(
            'label' => 'Identificador único'
        ))
        ->add('Encargado', 'entity_id', array(
            'label' => 'Encargado',
            'class' => 'Yacare\BaseBundle\Entity\Persona',
            'required' => false
        ))
        ->add('Firmware', null, array(
            'label' => 'Versión de Firmware'
        ))
        ->add('Obs', null, array(
            'label' => 'Observaciones'
        ));
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

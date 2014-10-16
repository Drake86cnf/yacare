<?php
namespace Yacare\RecursosHumanosBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PersonaAgenteType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Apellido', null, array(
                'label' => 'Apellido'
            ))
            ->add('Nombre', null, array(
                'label' => 'Nombre'
            ))
            ->add('Documento', new \Yacare\BaseBundle\Form\Type\DocumentoType(), array(
                'label' => 'Documento'
            ))
            ->add('Username', null, array(
                'label' => 'Usuario'
            ))
            ->add('Cuilt', null, array(
                'label' => 'CUIL/CUIT'
            ))
            ->add('Domicilio', new \Yacare\BaseBundle\Form\Type\DomicilioType(), array(
                'label' => 'Domicilio'
            ))
            ->add('TelefonoNumero', null, array(
                'label' => 'Teléfono(s)'
            ))
            ->add('Email', null, array(
                'label' => 'Correo electrónico'
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Yacare\BaseBundle\Entity\Persona'
        ));
    }

    public function getName()
    {
        return 'yacare_recursoshumanosbundle_personaagentetype';
    }
}

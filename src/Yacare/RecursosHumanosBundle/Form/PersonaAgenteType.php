<?php
namespace Yacare\RecursosHumanosBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PersonaAgenteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Apellido', null, array('label' => 'Apellido'))
            ->add('Nombre', null, array('label' => 'Nombre'))
            ->add('Documento', 'Yacare\BaseBundle\Form\Type\DocumentoType', array(
                'label' => 'Documento'))
            ->add('Username', null, array('label' => 'Usuario'))
            ->add('Cuilt', null, array('label' => 'CUIL/CUIT'))
            ->add('Domicilio', 'Yacare\BaseBundle\Form\Type\DomicilioType', array(
                'label' => 'Domicilio'))
            ->add('TelefonoNumero', null, array('label' => 'Teléfono(s)'))
            ->add('Email', 'Symfony\Component\Form\Extension\Core\Type\EmailType', array(
                'label' => 'Correo electrónico',
                'required' => false));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Yacare\BaseBundle\Entity\Persona'));
    }
}

<?php
namespace Yacare\TramitesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InstrumentoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Codigo', null, array('label' => 'Código'))
            ->add('Nombre', null, array('label' => 'Nombre'))
            ->add('Tipo', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType', array(
                'label' => 'Tipo', 
                'required' => true, 
                'choices' => array(
                    'Comprobante' => 'com', 
                    'Formulario' => 'for', 
                    'Instructivo' => 'ins', 
                    'Carpeta' => 'car')))
            ->add('Obs', null, array('label' => 'Obs.'));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array('data_class' => 'Yacare\TramitesBundle\Entity\Instrumento'));
    }
}

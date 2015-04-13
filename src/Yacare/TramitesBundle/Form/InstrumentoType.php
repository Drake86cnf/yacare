<?php
namespace Yacare\TramitesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class InstrumentoType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('Codigo', null, array('label' => 'Código'))
            ->add('Nombre', null, array('label' => 'Nombre'))
            ->add('Tipo', 'choice', 
            array(
                'label' => 'Tipo',
                'required' => true,
                'choices' => array(
                    'com' => 'Comprobante',
                    'for' => 'Formulario',
                    'ins' => 'Instructivo',
                    'car' => 'Carpeta')))
            ->add('Obs', null, array('label' => 'Obs.'));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array('data_class' => 'Yacare\TramitesBundle\Entity\Instrumento'));
    }

    public function getName()
    {
        return 'yacare_tramitesbundle_instrumentotype';
    }
}

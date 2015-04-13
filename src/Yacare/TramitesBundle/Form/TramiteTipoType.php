<?php
namespace Yacare\TramitesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TramiteTipoType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('Nombre', null, array('label' => 'Nombre'))
            ->add('Clase', null, array('label' => 'Clase'))
            ->add('Url', null, 
            array(
                'label' => 'Web',
                'attr' => array('placeholder' => 'Sitio web con información')))
            ->add('ComprobanteTipo', 'entity', 
            array(
                'label' => 'Comprobante final',
                'class' => 'YacareTramitesBundle:ComprobanteTipo',
                'required' => false,
                'multiple' => false))
            ->add('Formulario', 'entity', 
            array(
                'label' => 'Formulario inicial',
                'class' => 'YacareTramitesBundle:Instrumento',
                'required' => false,
                'multiple' => false))
            ->add('Obs', null, 
            array(
                'label' => 'Obs.',
                'attr' => array('class' => 'tinymce','data-theme' => 'simple')) // simple, advanced, bbcode
)
            ->add('Notas', null, array('label' => 'Notas al pie'));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array('data_class' => 'Yacare\TramitesBundle\Entity\TramiteTipo'));
    }

    public function getName()
    {
        return 'yacare_tramitesbundle_tramitetipotype';
    }
}

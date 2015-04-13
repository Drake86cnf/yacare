<?php
namespace Yacare\BaseBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AdjuntoType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        return $builder->add('NombreArchivo', 'file', array('label' => 'Archivo adjunto'));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'Yacare\BaseBundle\Entity\Adjunto',
                'csrf_protection' => true,
                'csrf_field_name' => '_token',
                'mapped' => false,
                'intention' => 'file'));
    }

    public function getName()
    {
        return 'yacare_basebundle_adjuntotype';
    }
}

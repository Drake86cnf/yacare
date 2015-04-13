<?php
namespace Yacare\ComercioBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ComercioType extends ComercioSimpleType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        
        $builder->add('Estado', 'choice', 
            array(
                'label' => 'Estado',
                'required' => true,
                'choices' => array(
                    0 => 'No habilitado',
                    1 => 'Habilitación en trámite',
                    91 => 'Habilitación vencida',
                    100 => 'Habilitado')));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array('data_class' => 'Yacare\ComercioBundle\Entity\Comercio'));
    }

    public function getName()
    {
        return 'yacare_tramitesbundle_comerciotype';
    }
}

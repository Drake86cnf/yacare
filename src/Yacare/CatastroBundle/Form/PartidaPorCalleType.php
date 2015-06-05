<?php
namespace Yacare\CatastroBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PartidaPorCalleType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('DomicilioCalle', 'entity', 
            array('label' => 'Calle','class' => 'YacareCatastroBundle:Calle','required' => true,'mapped' => false))
            ->add('DomicilioNumero', null, array('label' => 'Nº','mapped' => false))
            ->setAttribute('widget', 'form_horizontal');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array('inherit_data' => true,'class' => 'form_horizontal'));
    }

    public function getName()
    {
        return 'form_horizontal';
    }
}

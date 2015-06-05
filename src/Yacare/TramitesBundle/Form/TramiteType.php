<?php
namespace Yacare\TramitesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TramiteType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('Titular', 'entity_id', 
            array('label' => 'Titular','class' => 'Yacare\BaseBundle\Entity\Persona','required' => true));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array('data_class' => 'Yacare\TramitesBundle\Entity\Tramite'));
    }

    public function getName()
    {
        return 'yacare_tramitesbundle_tramitetype';
    }
}

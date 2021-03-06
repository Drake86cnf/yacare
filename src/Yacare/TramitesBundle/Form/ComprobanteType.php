<?php
namespace Yacare\TramitesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ComprobanteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('Titular', 'Tapir\FormBundle\Form\Type\EntityIdType', array(
            'label' => 'Titular',
            'property' => 'NombreVisible',
            'class' => 'Yacare\BaseBundle\Entity\Persona',
            'required' => true));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array('data_class' => 'Yacare\TramitesBundle\Entity\Comprobante'));
    }
}

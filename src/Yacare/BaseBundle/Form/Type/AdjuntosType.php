<?php
namespace Yacare\BaseBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdjuntosType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'csrf_protection' => true, 
                'csrf_field_name' => '_token', 
                'intention' => 'file', 
                'em' => null, 
                // 'data_class' => 'Bundle\Entity\File',
                'class' => 'Yacare\BaseBundle\Entity\Adjunto', 
                'property' => 'Nombre', 
                'mapped' => false, 
                'query_builder' => null, 
                'filters' => null, 
                'hidden' => true, 
                'multiple' => true));
    }

    public function getParent()
    {
        return 'file';
    }

    public function getName()
    {
        return 'adjuntos';
    }
}

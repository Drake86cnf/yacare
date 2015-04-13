<?php
namespace Yacare\BaseBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AdjuntosType extends AbstractType
{

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'csrf_protection' => true,
                'csrf_field_name' => '_token',
                'intention' => 'file',
                'em' => null,
            /* 'data_class'    => 'Bundle\Entity\File', */
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

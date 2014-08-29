<?php
namespace Yacare\BromatologiaBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MercaderiaType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('Huevo', null, array(
            'label' => 'Huevos',
            'required' => false
        ))
            ->add('Carne', null, array(
            'label' => 'Carnes',
            'required' => false
        ))
            ->add('Grasa', null, array(
            'label' => 'Grasas',
            'required' => false
        ))
            ->add('Mar', null, array(
            'label' => 'Prod. de Mar',
            'required' => false
        ))
            ->add('Embutido', null, array(
            'label' => 'Embutidos',
            'required' => false
        ))
            ->add('Chacinado', null, array(
            'label' => 'Chacinados',
            'required' => false
        ))
            ->add('Fiambre', null, array(
            'label' => 'Fiambres',
            'required' => false
        ))
            ->add('Lacteo', null, array(
            'label' => 'Lacteos',
            'required' => false
        ))
            ->add('Verdura', null, array(
            'label' => 'Verduras',
            'required' => false
        ))
            ->add('Fruta', null, array(
            'label' => 'Frutas',
            'required' => false
        ))
            ->add('Papa', null, array(
            'label' => 'Papas',
            'required' => false
        ))
            ->add('Almacen', null, array(
            'label' => 'Almacen',
            'required' => false
        ))
            ->add('Cerdo', null, array(
            'label' => 'Cerdo',
            'required' => false
        ))
            ->add('Pan', null, array(
            'label' => 'Panificados',
            'required' => false
        ))
            ->add('Ave', null, array(
            'label' => 'Aves',
            'required' => false
        ))
            ->add('Bebida', null, array(
            'label' => 'Bebidas',
            'required' => false
        ))
            ->setAttribute('widget', 'form_horizontal');
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'inherit_data' => true,
            'class' => 'form_horizontal'
        ));
    }

    public function getName()
    {
        return 'form_horizontal';
    }
}

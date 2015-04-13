<?php
namespace Yacare\ComercioBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ActividadesType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('ActividadPrincipal', 'entity_id', 
            array(
                'label' => 'Actividad principal',
                'class' => 'Yacare\ComercioBundle\Entity\Actividad',
                'required' => true))
            ->add('ActividadSecundaria', 'entity_id', 
            array(
                'label' => 'Actividad secundaria',
                'class' => 'Yacare\ComercioBundle\Entity\Actividad',
                'required' => false))
            ->add('ActividadTerciaria', 'entity_id', 
            array(
                'label' => 'Actividad terciaria',
                'class' => 'Yacare\ComercioBundle\Entity\Actividad',
                'required' => false))
            ->setAttribute('widget', 'form_horizontal');
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array('inherit_data' => true,'class' => 'form_horizontal'));
    }

    public function getName()
    {
        return 'form_horizontal';
    }
}

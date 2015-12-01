<?php
namespace Yacare\ComercioBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Formualario para actividades primaria, secundaria y terciaria.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class ActividadesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ActividadPrincipal', 'Tapir\FormBundle\Form\Type\EntityIdType', array(
                'label' => 'Actividad principal', 
                'class' => 'Yacare\ComercioBundle\Entity\Actividad', 
                'required' => true))
            ->add('ActividadSecundaria', 'Tapir\FormBundle\Form\Type\EntityIdType', array(
                'label' => 'Actividad secundaria', 
                'class' => 'Yacare\ComercioBundle\Entity\Actividad', 
                'required' => false))
            ->add('ActividadTerciaria', 'Tapir\FormBundle\Form\Type\EntityIdType', array(
                'label' => 'Actividad terciaria', 
                'class' => 'Yacare\ComercioBundle\Entity\Actividad', 
                'required' => false))
            ->setAttribute('widget', 'form_horizontal');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array('inherit_data' => true, 'class' => 'form_horizontal'));
    }
}

<?php
namespace Yacare\ObrasParticularesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Formulario de trámites de certificados de aptitud técnica.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class TramiteCatType extends \Yacare\TramitesBundle\Form\TramiteType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('Local', 'Tapir\FormBundle\Form\Type\EntityIdType', array(
                'label' => 'Local',
                'class' => 'Yacare\ComercioBundle\Entity\Local',
                'required' => true))
            ->add('Actividad1', 'Tapir\FormBundle\Form\Type\EntityIdType', array(
                'label' => 'Actividad 1',
                'class' => 'Yacare\ComercioBundle\Entity\Actividad',
                'required' => true))
            ->add('Actividad2', 'Tapir\FormBundle\Form\Type\EntityIdType', array(
                'label' => 'Actividad 2',
                'class' => 'Yacare\ComercioBundle\Entity\Actividad',
                'required' => false))
            ->add('Actividad3', 'Tapir\FormBundle\Form\Type\EntityIdType', array(
                'label' => 'Actividad 3',
                'class' => 'Yacare\ComercioBundle\Entity\Actividad',
                'required' => false))
            ->add('Actividad4', 'Tapir\FormBundle\Form\Type\EntityIdType', array(
                'label' => 'Actividad 4',
                'class' => 'Yacare\ComercioBundle\Entity\Actividad',
                'required' => false))
            ->add('Actividad5', 'Tapir\FormBundle\Form\Type\EntityIdType', array(
                'label' => 'Actividad 5',
                'class' => 'Yacare\ComercioBundle\Entity\Actividad',
                'required' => false))
            ->add('Actividad6', 'Tapir\FormBundle\Form\Type\EntityIdType', array(
                'label' => 'Actividad 6',
                'class' => 'Yacare\ComercioBundle\Entity\Actividad',
                'required' => false));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Yacare\ObrasParticularesBundle\Entity\TramiteCat'));
    }
}

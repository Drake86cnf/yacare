<?php
namespace Yacare\ComercioBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Formulario con datos adicionales para un comercio.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class ComercioType extends ComercioSimpleType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('Titular', 'Tapir\FormBundle\Form\Type\EntityIdType', array(
                'label' => 'Titular',
                'class' => 'Yacare\BaseBundle\Entity\Persona',
                'property' => 'NombreVisible',
                'required' => true))
            ->add('FechaHabilitacion', 'Tapir\BaseBundle\Form\Type\FechaType', array(
                'label' => 'Fecha de habilitación',
                'required' => false))
            ->add('FechaBaja', 'Tapir\BaseBundle\Form\Type\FechaType', array(
                'label' => 'Fecha de baja',
                'required' => false))
            ->add('Estado', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType', array(
                'label' => 'Estado',
                'required' => true,
                'choices' => array(
                    'En actividad, sin habilitación' => 0,
                    'Habilitación en trámite' => 1,
                    'Habilitado, sin actividad' => 90,
                    'Habilitación vencida' => 91,
                    'Dado de baja' => 92,
                    'En actividad, habilitado' => 100)))
            ->add('Obs', null, array(
                'label' => 'Observaciones',
                'attr' => array('class' => 'tapir-input-maymin')));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array('data_class' => 'Yacare\ComercioBundle\Entity\Comercio'));
    }
}

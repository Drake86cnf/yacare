<?php
namespace Yacare\RequerimientosBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Formulario para rechazo de un requerimiento.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class RechazarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('Notas', null, array('label' => 'Motivo del rechazo', 'required' => true))
            ->add('Usuario', 'Tapir\FormBundle\Form\Type\EntityHiddenType', array(
                'property' => 'NombreVisible',
                'class' => 'Yacare\BaseBundle\Entity\Persona'))
            ->add('Requerimiento', 'Tapir\FormBundle\Form\Type\EntityHiddenType', array(
                'class' => 'Yacare\RequerimientosBundle\Entity\Requerimiento'));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array('data_class' => 'Yacare\RequerimientosBundle\Entity\Novedad'));
    }
}

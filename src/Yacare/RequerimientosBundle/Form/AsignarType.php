<?php
namespace Yacare\RequerimientosBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Formulario para asignación de un requerimiento.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class AsignarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('Notas', null, array(
                'label' => 'Notas',
                'required' => false))
            ->add('Usuario', 'entity', array(
                'label' => 'Encargado',
                'property' => 'NombreVisible',
                'class' => 'Yacare\BaseBundle\Entity\Persona',
                'query_builder' => function (\Yacare\BaseBundle\Entity\PersonaRepository $er) {
                    return $er->ObtenerQueryBuilderPorRol('ROLE_REQUERIMIENTOS_ENCARGADO');
                }))
            ->add('Requerimiento', 'entity_hidden', array(
                'class' => 'Yacare\RequerimientosBundle\Entity\Requerimiento'));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Yacare\RequerimientosBundle\Entity\Novedad'));
    }

    public function getName()
    {
        return 'yacare_requerimientosbundle_asignartype';
    }
}

<?php
namespace Yacare\RequerimientosBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

/**
 * Formulario de categoría.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class CategoriaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('Nombre', null, array(
                'label' => 'Nombre',
                'required' => true))
            ->add('Obs', null, array(
                'label' => 'Obs.',
                'required' => false))
            ->add('Encargado', EntityType::class, array(
                'label' => 'Encargado predet.',
                'choice_label' => 'NombreVisible',
                'class' => 'Yacare\BaseBundle\Entity\Persona',
                'query_builder' => function (\Yacare\BaseBundle\Entity\PersonaRepository $er) {
                    return $er->ObtenerQueryBuilderPorRol('ROLE_REQUERIMIENTOS_ENCARGADO');
                },
                'required' => false))
            ->add('PermiteAnonimos', 'Tapir\BaseBundle\Form\Type\SiNoType', array(
                'label' => 'Admite anónimos',
                'required' => true));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Yacare\RequerimientosBundle\Entity\Categoria'));
    }
}
